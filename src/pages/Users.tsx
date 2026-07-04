import { useEffect, useState } from 'react';
import AdminLayout from '../components/admin/AdminLayout';
import Modal from '../components/ui/Modal';
import { supabase } from '../lib/supabase';
import type { Profile } from '../types';

export default function Users() {
  const [users, setUsers] = useState<Profile[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [filterRole, setFilterRole] = useState('all');
  const [editing, setEditing] = useState<Profile | null>(null);
  const [editName, setEditName] = useState('');
  const [editRole, setEditRole] = useState<'admin' | 'parent'>('parent');
  const [resetUser, setResetUser] = useState<Profile | null>(null);
  const [newPassword, setNewPassword] = useState('');
  const [resetMsg, setResetMsg] = useState<string | null>(null);
  const [deleteUser, setDeleteUser] = useState<Profile | null>(null);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetchUsers();
  }, []);

  async function fetchUsers() {
    const { data } = await supabase
      .from('profiles')
      .select('id, full_name, role, created_at')
      .order('created_at', { ascending: false });
    // Fetch emails from auth via the profiles join — we can't directly query auth.users,
    // but we can get the email from the current session's user. For other users,
    // we'll show what we have.
    setUsers((data || []) as Profile[]);
    setLoading(false);
  }

  const filtered = users.filter((u) => {
    if (filterRole !== 'all' && u.role !== filterRole) return false;
    if (search) {
      return u.full_name?.toLowerCase().includes(search.toLowerCase());
    }
    return true;
  });

  async function handleEditSave() {
    if (!editing) return;
    setSaving(true);
    setError(null);
    const { error } = await supabase
      .from('profiles')
      .update({ full_name: editName, role: editRole })
      .eq('id', editing.id);
    setSaving(false);
    if (error) {
      setError(error.message);
    } else {
      setUsers(users.map((u) => (u.id === editing.id ? { ...u, full_name: editName, role: editRole } : u)));
      setEditing(null);
    }
  }

  async function handleResetPassword() {
    if (!resetUser || !newPassword) return;
    setSaving(true);
    setResetMsg(null);
    // Note: Supabase admin can update user password via the admin API,
    // but the anon client can't. We'll use the auth.updateUser for the current user,
    // or show a message for other users. For a proper admin reset, this would
    // need a service-role key (edge function). For now, we'll attempt it.
    const { data: userData } = await supabase.auth.getUser();
    if (resetUser.id === userData.user?.id) {
      const { error } = await supabase.auth.updateUser({ password: newPassword });
      if (error) {
        setResetMsg(`Error: ${error.message}`);
      } else {
        setResetMsg('Password updated successfully.');
        setResetUser(null);
        setNewPassword('');
      }
    } else {
      setResetMsg('Password reset for other users requires an admin edge function. Please use the Supabase dashboard to reset this user\'s password.');
    }
    setSaving(false);
  }

  async function handleDelete() {
    if (!deleteUser) return;
    setSaving(true);
    setError(null);
    // Delete the profile — the auth.users entry needs to be deleted via admin API
    const { error } = await supabase.from('profiles').delete().eq('id', deleteUser.id);
    setSaving(false);
    if (error) {
      setError(error.message);
    } else {
      setUsers(users.filter((u) => u.id !== deleteUser.id));
      setDeleteUser(null);
    }
  }

  const stats = {
    total: users.length,
    admins: users.filter((u) => u.role === 'admin').length,
    parents: users.filter((u) => u.role === 'parent').length,
  };

  return (
    <AdminLayout
      title="Users"
      description="Manage all users — parents and administrators. Edit roles, reset passwords, or remove accounts."
      breadcrumb={[{ label: 'Settings' }, { label: 'Users' }]}
    >
      {/* Stats */}
      <div className="grid grid-cols-3 gap-stack-md mb-stack-lg">
        {[
          { label: 'Total Users', value: stats.total, icon: 'group', bg: 'bg-primary/10 text-primary' },
          { label: 'Administrators', value: stats.admins, icon: 'admin_panel_settings', bg: 'bg-deep-navy/10 text-deep-navy' },
          { label: 'Parents', value: stats.parents, icon: 'family_restroom', bg: 'bg-secondary/10 text-secondary' },
        ].map((s) => (
          <div key={s.label} className="glass-card p-stack-md rounded-2xl">
            <span className={`p-2 rounded-lg ${s.bg} material-symbols-outlined text-[20px] mb-2 inline-block`}>{s.icon}</span>
            <p className="text-[28px] font-bold text-primary leading-none">{s.value}</p>
            <p className="text-label-sm text-on-surface-variant mt-1">{s.label}</p>
          </div>
        ))}
      </div>

      {/* Filter Bar */}
      <div className="glass-card rounded-2xl p-stack-md mb-stack-lg flex flex-wrap gap-4 items-end">
        <div className="flex-1 min-w-[200px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Search</label>
          <input type="text" value={search} onChange={(e) => setSearch(e.target.value)} placeholder="Name..." className="input-field" />
        </div>
        <div className="flex-1 min-w-[150px]">
          <label className="block font-label-bold text-label-bold text-primary mb-1">Role</label>
          <select value={filterRole} onChange={(e) => setFilterRole(e.target.value)} className="input-field">
            <option value="all">All Roles</option>
            <option value="admin">Admin</option>
            <option value="parent">Parent</option>
          </select>
        </div>
      </div>

      {/* Table */}
      <div className="glass-card rounded-2xl overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="bg-primary/5">
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Name</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Role</th>
                <th className="text-left font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider hidden md:table-cell">Joined</th>
                <th className="text-right font-label-bold text-label-bold text-on-surface-variant px-stack-md py-stack-md uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody>
              {loading && <tr><td colSpan={4} className="text-center py-stack-lg text-on-surface-variant">Loading...</td></tr>}
              {!loading && filtered.length === 0 && <tr><td colSpan={4} className="text-center py-stack-lg text-on-surface-variant">No users found.</td></tr>}
              {filtered.map((u) => (
                <tr key={u.id} className="border-t border-glass-border hover:bg-primary/5 transition-colors">
                  <td className="px-stack-md py-stack-md">
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold text-sm shrink-0">
                        {u.full_name?.charAt(0).toUpperCase() || '?'}
                      </div>
                      <p className="font-bold text-primary">{u.full_name || 'Unknown'}</p>
                    </div>
                  </td>
                  <td className="px-stack-md py-stack-md">
                    <span className={`status-badge ${u.role === 'admin' ? 'bg-deep-navy/10 text-deep-navy' : 'bg-secondary/10 text-secondary'}`}>
                      {u.role}
                    </span>
                  </td>
                  <td className="px-stack-md py-stack-md hidden md:table-cell text-label-sm text-on-surface-variant">
                    {new Date(u.created_at).toLocaleDateString('en-MY', { day: '2-digit', month: 'short', year: 'numeric' })}
                  </td>
                  <td className="px-stack-md py-stack-md text-right">
                    <div className="flex items-center justify-end gap-1">
                      <button
                        onClick={() => { setEditing(u); setEditName(u.full_name); setEditRole(u.role); setError(null); }}
                        className="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-lg transition-colors"
                        title="Edit"
                      >
                        <span className="material-symbols-outlined text-[20px]">edit</span>
                      </button>
                      <button
                        onClick={() => { setResetUser(u); setNewPassword(''); setResetMsg(null); }}
                        className="p-2 text-on-surface-variant hover:text-energetic-orange hover:bg-energetic-orange/10 rounded-lg transition-colors"
                        title="Reset Password"
                      >
                        <span className="material-symbols-outlined text-[20px]">key</span>
                      </button>
                      <button
                        onClick={() => { setDeleteUser(u); setError(null); }}
                        className="p-2 text-on-surface-variant hover:text-error hover:bg-error/10 rounded-lg transition-colors"
                        title="Delete"
                      >
                        <span className="material-symbols-outlined text-[20px]">delete</span>
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Edit Modal */}
      <Modal
        open={!!editing}
        onClose={() => setEditing(null)}
        title="Edit User"
        maxWidth="max-w-md"
        footer={
          <>
            <button onClick={() => setEditing(null)} className="btn-secondary">Cancel</button>
            <button onClick={handleEditSave} disabled={saving} className="btn-primary disabled:opacity-50">
              {saving ? <span className="material-symbols-outlined animate-spin">progress_activity</span> : <span className="material-symbols-outlined">save</span>}
              Save Changes
            </button>
          </>
        }
      >
        {editing && (
          <div className="space-y-4">
            {error && (
              <div className="bg-error-container/60 text-error px-4 py-3 rounded-xl flex items-center gap-2">
                <span className="material-symbols-outlined">error</span>
                <span>{error}</span>
              </div>
            )}
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Full Name</label>
              <input type="text" value={editName} onChange={(e) => setEditName(e.target.value)} className="input-field" />
            </div>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">Role</label>
              <select value={editRole} onChange={(e) => setEditRole(e.target.value as 'admin' | 'parent')} className="input-field">
                <option value="parent">Parent</option>
                <option value="admin">Admin</option>
              </select>
            </div>
          </div>
        )}
      </Modal>

      {/* Reset Password Modal */}
      <Modal
        open={!!resetUser}
        onClose={() => setResetUser(null)}
        title="Reset Password"
        maxWidth="max-w-md"
        footer={
          <>
            <button onClick={() => setResetUser(null)} className="btn-secondary">Cancel</button>
            <button onClick={handleResetPassword} disabled={saving || !newPassword} className="btn-primary disabled:opacity-50">
              {saving ? <span className="material-symbols-outlined animate-spin">progress_activity</span> : <span className="material-symbols-outlined">key</span>}
              Reset Password
            </button>
          </>
        }
      >
        {resetUser && (
          <div className="space-y-4">
            <p className="text-body-md text-on-surface-variant">
              Reset password for <span className="font-bold text-primary">{resetUser.full_name}</span>
            </p>
            <div>
              <label className="block font-label-bold text-label-bold text-primary mb-1">New Password</label>
              <input type="password" value={newPassword} onChange={(e) => setNewPassword(e.target.value)} placeholder="Minimum 8 characters" className="input-field" />
            </div>
            {resetMsg && (
              <div className={`px-4 py-3 rounded-xl flex items-center gap-2 ${resetMsg.startsWith('Error') || resetMsg.includes('requires') ? 'bg-tertiary-fixed/40 text-energetic-orange' : 'bg-secondary-container/20 text-secondary'}`}>
                <span className="material-symbols-outlined">info</span>
                <span className="text-body-md">{resetMsg}</span>
              </div>
            )}
          </div>
        )}
      </Modal>

      {/* Delete Confirmation */}
      <Modal
        open={!!deleteUser}
        onClose={() => setDeleteUser(null)}
        title="Delete User"
        maxWidth="max-w-md"
        footer={
          <>
            <button onClick={() => setDeleteUser(null)} className="btn-secondary">Cancel</button>
            <button onClick={handleDelete} disabled={saving} className="btn-danger disabled:opacity-50">
              {saving ? <span className="material-symbols-outlined animate-spin">progress_activity</span> : <span className="material-symbols-outlined">delete</span>}
              Delete User
            </button>
          </>
        }
      >
        {deleteUser && (
          <div className="space-y-4">
            {error && (
              <div className="bg-error-container/60 text-error px-4 py-3 rounded-xl flex items-center gap-2">
                <span className="material-symbols-outlined">error</span>
                <span>{error}</span>
              </div>
            )}
            <div className="flex items-center gap-3">
              <div className="w-12 h-12 rounded-full bg-error/10 flex items-center justify-center text-error">
                <span className="material-symbols-outlined">warning</span>
              </div>
              <div>
                <p className="text-body-md text-on-surface">
                  Are you sure you want to delete <span className="font-bold text-primary">{deleteUser.full_name}</span>?
                </p>
                <p className="text-label-sm text-on-surface-variant mt-1">
                  This will remove their profile and all associated data (children, fees, etc.). This cannot be undone.
                </p>
              </div>
            </div>
          </div>
        )}
      </Modal>
    </AdminLayout>
  );
}
