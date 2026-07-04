import { useEffect, useState, type FormEvent } from 'react';
import AdminLayout from '../components/admin/AdminLayout';
import Modal from '../components/ui/Modal';
import { supabase } from '../lib/supabase';
import type { RegistrationForm, FormField } from '../types';

const fieldTypes: { type: FormField['type']; label: string; icon: string }[] = [
  { type: 'text', label: 'Text', icon: 'text_fields' },
  { type: 'email', label: 'Email', icon: 'mail' },
  { type: 'phone', label: 'Phone', icon: 'call' },
  { type: 'number', label: 'Number', icon: 'pin' },
  { type: 'radio', label: 'Radio', icon: 'radio_button_checked' },
  { type: 'checkbox', label: 'Check', icon: 'check_box' },
  { type: 'date', label: 'Date', icon: 'calendar_today' },
  { type: 'upload', label: 'Upload', icon: 'upload_file' },
  { type: 'textarea', label: 'Textarea', icon: 'notes' },
  { type: 'select', label: 'Select', icon: 'list' },
];

const defaultFields: FormField[] = [
  { id: 'f1', type: 'text', label: 'Full Name', placeholder: 'Enter student full name', required: true, section: 'Student Details' },
  { id: 'f2', type: 'text', label: 'Identification Number', placeholder: 'IC / Passport No.', required: true, section: 'Student Details' },
  { id: 'f3', type: 'email', label: 'Email', placeholder: 'student@email.com', required: false, section: 'Student Details' },
  { id: 'f4', type: 'select', label: 'Year of Study', placeholder: 'Select year', required: false, section: 'Student Details', options: ['Year 1', 'Year 2', 'Year 3', 'Year 4', 'Year 5', 'Year 6'] },
  { id: 'f5', type: 'text', label: 'School', placeholder: 'School name', required: false, section: 'Student Details' },
  { id: 'f6', type: 'text', label: 'Guardian Name', placeholder: 'Guardian full name', required: true, section: 'Guardian Details' },
  { id: 'f7', type: 'phone', label: 'Guardian Phone', placeholder: 'Phone number', required: true, section: 'Guardian Details' },
];

function genId() {
  return `f${Date.now()}_${Math.random().toString(36).slice(2, 7)}`;
}

export default function Forms() {
  const [forms, setForms] = useState<RegistrationForm[]>([]);
  const [loading, setLoading] = useState(true);
  const [editing, setEditing] = useState<RegistrationForm | null>(null);
  const [showBuilder, setShowBuilder] = useState(false);

  // Builder state
  const [formTitle, setFormTitle] = useState('');
  const [formDesc, setFormDesc] = useState('');
  const [formBanner, setFormBanner] = useState('');
  const [accentColor, setAccentColor] = useState('vibrant-green');
  const [fields, setFields] = useState<FormField[]>(defaultFields);
  const [editingField, setEditingField] = useState<FormField | null>(null);
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    fetchForms();
  }, []);

  async function fetchForms() {
    const { data } = await supabase
      .from('registration_forms')
      .select('*, submission_count:registration_submissions(count)')
      .order('created_at', { ascending: false });
    setForms((data || []) as unknown as RegistrationForm[]);
    setLoading(false);
  }

  function openNewForm() {
    setEditing(null);
    setFormTitle('');
    setFormDesc('');
    setFormBanner('');
    setAccentColor('vibrant-green');
    setFields(defaultFields);
    setShowBuilder(true);
  }

  function openEditForm(form: RegistrationForm) {
    setEditing(form);
    setFormTitle(form.title);
    setFormDesc(form.description);
    setFormBanner(form.banner_url);
    setAccentColor(form.accent_color);
    setFields(form.fields || defaultFields);
    setShowBuilder(true);
  }

  async function generateSlug(): Promise<string> {
    const { count } = await supabase
      .from('registration_forms')
      .select('id', { count: 'exact', head: true });
    const num = String((count || 0) + 1).padStart(6, '0');
    return `newreg-${num}`;
  }

  async function handleSave(e: FormEvent) {
    e.preventDefault();
    setSaving(true);
    try {
      if (editing) {
        const { error } = await supabase
          .from('registration_forms')
          .update({
            title: formTitle,
            description: formDesc,
            fields,
            banner_url: formBanner,
            accent_color: accentColor,
            updated_at: new Date().toISOString(),
          })
          .eq('id', editing.id);
        if (!error) {
          await fetchForms();
          setShowBuilder(false);
        }
      } else {
        const slug = await generateSlug();
        const { error } = await supabase.from('registration_forms').insert({
          slug,
          title: formTitle,
          description: formDesc,
          fields,
          banner_url: formBanner,
          accent_color: accentColor,
          is_published: true,
        });
        if (!error) {
          await fetchForms();
          setShowBuilder(false);
        }
      }
    } finally {
      setSaving(false);
    }
  }

  function addField(type: FormField['type']) {
    const newField: FormField = {
      id: genId(),
      type,
      label: 'New Field',
      placeholder: '',
      required: false,
      section: 'Student Details',
      ...(type === 'select' || type === 'radio' ? { options: ['Option 1'] } : {}),
    };
    setFields([...fields, newField]);
    setEditingField(newField);
  }

  function updateField(updated: FormField) {
    setFields(fields.map((f) => (f.id === updated.id ? updated : f)));
  }

  function deleteField(id: string) {
    setFields(fields.filter((f) => f.id !== id));
  }

  function moveField(id: string, dir: 'up' | 'down') {
    const idx = fields.findIndex((f) => f.id === id);
    if (idx === -1) return;
    const newIdx = dir === 'up' ? idx - 1 : idx + 1;
    if (newIdx < 0 || newIdx >= fields.length) return;
    const newFields = [...fields];
    [newFields[idx], newFields[newIdx]] = [newFields[newIdx], newFields[idx]];
    setFields(newFields);
  }

  const sections = [...new Set(fields.map((f) => f.section))];

  return (
    <AdminLayout
      title="Form Settings"
      description="Create and edit registration forms. Each new form generates a unique slug (newreg-######)."
      breadcrumb={[{ label: 'Registration' }, { label: 'Form Settings' }]}
      actions={
        <button onClick={openNewForm} className="btn-primary">
          <span className="material-symbols-outlined">add_circle</span>
          Create New Form
        </button>
      }
    >
      {/* Forms List */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
        {loading && <p className="text-on-surface-variant">Loading forms...</p>}
        {!loading && forms.length === 0 && (
          <div className="col-span-full glass-card p-stack-lg rounded-2xl text-center">
            <span className="material-symbols-outlined text-[48px] text-on-surface-variant mb-4 block">dynamic_form</span>
            <p className="text-body-lg text-on-surface-variant mb-4">No registration forms yet.</p>
            <button onClick={openNewForm} className="btn-primary">
              <span className="material-symbols-outlined">add_circle</span>
              Create Your First Form
            </button>
          </div>
        )}
        {forms.map((form) => (
          <div key={form.id} className="glass-card p-stack-lg rounded-2xl flex flex-col">
            <div className="flex items-start justify-between mb-4">
              <div className="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                <span className="material-symbols-outlined">dynamic_form</span>
              </div>
              {form.is_published ? (
                <span className="status-badge bg-secondary-container/40 text-secondary">
                  <span className="w-1.5 h-1.5 rounded-full bg-secondary" />
                  Published
                </span>
              ) : (
                <span className="status-badge bg-surface-container-high text-on-surface-variant">
                  <span className="w-1.5 h-1.5 rounded-full bg-on-surface-variant" />
                  Draft
                </span>
              )}
            </div>
            <h3 className="font-headline-sm text-headline-sm text-primary mb-1">{form.title}</h3>
            <p className="text-label-sm text-on-surface-variant mb-2">{form.description || 'No description'}</p>
            <div className="bg-surface-container-low rounded-lg px-3 py-2 mb-4">
              <p className="text-label-sm text-on-surface-variant">Form URL slug:</p>
              <p className="font-label-bold text-primary text-body-md">/claude/{form.slug}</p>
            </div>
            <div className="flex items-center gap-4 text-label-sm text-on-surface-variant mb-4">
              <span className="flex items-center gap-1">
                <span className="material-symbols-outlined text-[16px]">list_alt</span>
                {form.fields?.length || 0} fields
              </span>
              <span className="flex items-center gap-1">
                <span className="material-symbols-outlined text-[16px]">inbox</span>
                {form.submission_count && Array.isArray(form.submission_count)
                  ? form.submission_count[0]?.count || 0
                  : typeof form.submission_count === 'number'
                  ? form.submission_count
                  : 0} submissions
              </span>
            </div>
            <div className="flex gap-2 mt-auto">
              <button onClick={() => openEditForm(form)} className="btn-secondary flex-1 justify-center">
                <span className="material-symbols-outlined">edit</span>
                Edit
              </button>
            </div>
          </div>
        ))}
      </div>

      {/* Form Builder Modal */}
      <Modal
        open={showBuilder}
        onClose={() => setShowBuilder(false)}
        title={editing ? 'Edit Form' : 'Create New Form'}
        maxWidth="max-w-5xl"
        footer={
          <>
            <button onClick={() => setShowBuilder(false)} className="btn-secondary">
              Cancel
            </button>
            <button onClick={handleSave} disabled={saving || !formTitle} className="btn-primary disabled:opacity-50">
              {saving ? <span className="material-symbols-outlined animate-spin">progress_activity</span> : <span className="material-symbols-outlined">save</span>}
              {editing ? 'Save Changes' : 'Create Form'}
            </button>
          </>
        }
      >
        <div className="space-y-6">
          {/* Form Settings */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="md:col-span-2">
              <label className="block font-label-bold text-label-bold text-primary mb-1">Form Title</label>
              <input
                type="text"
                value={formTitle}
                onChange={(e) => setFormTitle(e.target.value)}
                placeholder="e.g. Microbit Robotics Registration"
                className="input-field"
              />
            </div>
            <div className="md:col-span-2">
              <label className="block font-label-bold text-label-bold text-primary mb-1">Description</label>
              <input
                type="text"
                value={formDesc}
                onChange={(e) => setFormDesc(e.target.value)}
                placeholder="Short description of the form"
                className="input-field"
              />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Banner Image URL</label>
              <input
                type="text"
                value={formBanner}
                onChange={(e) => setFormBanner(e.target.value)}
                placeholder="https://..."
                className="input-field"
              />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Accent Color</label>
              <div className="flex gap-2">
                {['vibrant-green', 'deep-navy', 'energetic-orange', 'error'].map((c) => (
                  <button
                    key={c}
                    type="button"
                    onClick={() => setAccentColor(c)}
                    className={`w-10 h-10 rounded-full border-2 transition-all ${
                      accentColor === c ? 'border-primary scale-110' : 'border-transparent'
                    }`}
                    style={{
                      background:
                        c === 'vibrant-green' ? '#48BB78' :
                        c === 'deep-navy' ? '#1A365D' :
                        c === 'energetic-orange' ? '#ED8936' : '#ba1a1a',
                    }}
                  />
                ))}
              </div>
            </div>
          </div>

          {/* Field Toolbox */}
          <div>
            <p className="font-label-bold text-label-bold text-primary mb-2">Add Fields</p>
            <div className="grid grid-cols-3 md:grid-cols-5 gap-2">
              {fieldTypes.map((ft) => (
                <button
                  key={ft.type}
                  type="button"
                  onClick={() => addField(ft.type)}
                  className="flex flex-col items-center gap-1 p-3 bg-surface-container-low rounded-xl hover:bg-surface-container transition-colors"
                >
                  <span className="material-symbols-outlined text-primary">{ft.icon}</span>
                  <span className="text-label-sm font-label-bold text-on-surface">{ft.label}</span>
                </button>
              ))}
            </div>
          </div>

          {/* Canvas - Fields by Section */}
          <div>
            <p className="font-label-bold text-label-bold text-primary mb-2">Form Fields</p>
            <div className="space-y-4">
              {sections.map((section) => (
                <div key={section} className="glass-card border-l-4 border-primary rounded-xl p-4" style={{ borderLeftColor: '#1A365D' }}>
                  <h4 className="font-label-bold text-label-bold text-primary mb-3">{section}</h4>
                  <div className="space-y-2">
                    {fields.filter((f) => f.section === section).map((field) => {
                      const globalIdx = fields.indexOf(field);
                      return (
                        <div
                          key={field.id}
                          className="group flex items-center gap-3 bg-surface-container-low rounded-lg p-3 hover:bg-surface-container transition-colors"
                        >
                          <span className="material-symbols-outlined text-on-surface-variant cursor-grab">drag_indicator</span>
                          <div className="flex-1">
                            <div className="flex items-center gap-2">
                              <span className="font-bold text-primary text-body-md">{field.label}</span>
                              {field.required && (
                                <span className="text-[10px] bg-error/10 text-error px-2 py-0.5 rounded-full font-bold">Required</span>
                              )}
                              <span className="text-label-sm text-on-surface-variant capitalize">· {field.type}</span>
                            </div>
                            {field.placeholder && (
                              <p className="text-label-sm text-on-surface-variant">{field.placeholder}</p>
                            )}
                          </div>
                          <div className="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button
                              type="button"
                              onClick={() => moveField(field.id, 'up')}
                              disabled={globalIdx === 0}
                              className="p-1 text-on-surface-variant hover:text-primary disabled:opacity-30"
                            >
                              <span className="material-symbols-outlined text-[18px]">arrow_upward</span>
                            </button>
                            <button
                              type="button"
                              onClick={() => moveField(field.id, 'down')}
                              disabled={globalIdx === fields.length - 1}
                              className="p-1 text-on-surface-variant hover:text-primary disabled:opacity-30"
                            >
                              <span className="material-symbols-outlined text-[18px]">arrow_downward</span>
                            </button>
                            <button
                              type="button"
                              onClick={() => setEditingField(field)}
                              className="p-1 text-on-surface-variant hover:text-primary"
                            >
                              <span className="material-symbols-outlined text-[18px]">settings</span>
                            </button>
                            <button
                              type="button"
                              onClick={() => deleteField(field.id)}
                              className="p-1 text-on-surface-variant hover:text-error"
                            >
                              <span className="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>
              ))}
              {fields.length === 0 && (
                <div className="text-center py-8 text-on-surface-variant border-2 border-dashed border-glass-border rounded-xl">
                  No fields yet. Add fields from the toolbox above.
                </div>
              )}
            </div>
          </div>
        </div>
      </Modal>

      {/* Field Editor Modal */}
      <Modal
        open={!!editingField}
        onClose={() => setEditingField(null)}
        title="Edit Field"
        maxWidth="max-w-lg"
        footer={
          <>
            <button onClick={() => setEditingField(null)} className="btn-secondary">Done</button>
          </>
        }
      >
        {editingField && (
          <div className="space-y-4">
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Label</label>
              <input
                type="text"
                value={editingField.label}
                onChange={(e) => setEditingField({ ...editingField, label: e.target.value })}
                className="input-field"
              />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Placeholder</label>
              <input
                type="text"
                value={editingField.placeholder}
                onChange={(e) => setEditingField({ ...editingField, placeholder: e.target.value })}
                className="input-field"
              />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Section</label>
              <input
                type="text"
                value={editingField.section}
                onChange={(e) => setEditingField({ ...editingField, section: e.target.value })}
                className="input-field"
              />
            </div>
            <div className="flex items-center gap-2">
              <input
                type="checkbox"
                id="required"
                checked={editingField.required}
                onChange={(e) => setEditingField({ ...editingField, required: e.target.checked })}
                className="w-5 h-5 rounded accent-primary"
              />
              <label htmlFor="required" className="font-label-bold text-label-bold text-primary">Required field</label>
            </div>
            {(editingField.type === 'select' || editingField.type === 'radio') && (
              <div>
                <label className="block font-label-bold text-label-bold text-primary mb-1">Options (one per line)</label>
                <textarea
                  value={(editingField.options || []).join('\n')}
                  onChange={(e) => setEditingField({ ...editingField, options: e.target.value.split('\n').filter(Boolean) })}
                  rows={4}
                  className="input-field"
                />
              </div>
            )}
            <button
              onClick={() => {
                updateField(editingField);
                setEditingField(null);
              }}
              className="btn-primary w-full justify-center"
            >
              <span className="material-symbols-outlined">save</span>
              Save Field
            </button>
          </div>
        )}
      </Modal>
    </AdminLayout>
  );
}
