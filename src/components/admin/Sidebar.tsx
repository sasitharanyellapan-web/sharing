import { NavLink, useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

interface NavItem {
  to: string;
  label: string;
  icon: string;
  group?: string;
}

const navItems: NavItem[] = [
  { to: '/', label: 'Dashboard', icon: 'dashboard' },
  { to: '/registrations', label: 'New Registration', icon: 'dynamic_form', group: 'Registration' },
  { to: '/forms', label: 'Form Settings', icon: 'edit_note', group: 'Registration' },
  { to: '/classrooms', label: 'Classrooms', icon: 'groups', group: 'Management' },
  { to: '/students', label: 'Students', icon: 'person_search', group: 'Management' },
  { to: '/attendance', label: 'Attendance', icon: 'fact_check', group: 'Management' },
  { to: '/fees', label: 'Fee Management', icon: 'payments', group: 'Management' },
  { to: '/attendance-report', label: 'Attendance Report', icon: 'summarize', group: 'Management' },
  { to: '/users', label: 'Users', icon: 'manage_accounts', group: 'Settings' },
];

export default function Sidebar() {
  const { profile, signOut } = useAuth();
  const navigate = useNavigate();

  const initials = profile?.full_name
    ? profile.full_name.split(' ').map((p) => p[0]).slice(0, 2).join('').toUpperCase()
    : 'A';

  const handleSignOut = async () => {
    await signOut();
    navigate('/login');
  };

  let lastGroup = '';

  return (
    <nav className="h-screen w-72 flex-col fixed left-0 top-0 border-r border-glass-border backdrop-blur-md bg-glass-surface/30 z-50 p-stack-lg flex">
      <div className="mb-stack-lg">
        <div className="flex items-center gap-stack-sm mb-1">
          <div className="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-on-primary font-bold text-lg">
            CG
          </div>
          <div>
            <h1 className="font-headline-sm text-headline-sm font-bold text-primary">Code Geek Admin</h1>
            <p className="font-label-sm text-label-sm text-on-surface-variant">Management Portal</p>
          </div>
        </div>
      </div>

      <div className="flex flex-col gap-1 flex-grow overflow-y-auto">
        {navItems.map((item) => {
          const showGroup = item.group && item.group !== lastGroup;
          if (item.group) lastGroup = item.group;
          return (
            <div key={item.to}>
              {showGroup && <div className="sidebar-group-label">{item.group}</div>}
              <NavLink to={item.to} end={item.to === '/'}>
                {({ isActive }) => (
                  <div
                    className={
                      isActive
                        ? 'flex items-center gap-stack-md px-gutter py-stack-md bg-secondary-container text-on-secondary-container rounded-xl transition-all duration-300'
                        : 'flex items-center gap-stack-md px-gutter py-stack-md text-on-surface-variant hover:text-primary hover:translate-x-1 hover:bg-surface-variant/50 transition-all rounded-xl'
                    }
                  >
                    <span
                      className="material-symbols-outlined"
                      style={isActive ? { fontVariationSettings: "'FILL' 1" } : undefined}
                    >
                      {item.icon}
                    </span>
                    <span className="font-label-bold text-label-bold">{item.label}</span>
                  </div>
                )}
              </NavLink>
            </div>
          );
        })}
      </div>

      <div className="mt-auto border-t border-glass-border pt-stack-md flex flex-col gap-1">
        <div className="flex items-center gap-stack-md px-gutter py-stack-md">
          <div className="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold">
            {initials}
          </div>
          <div className="min-w-0">
            <p className="text-label-sm font-label-bold text-primary truncate">
              {profile?.full_name || 'Admin'}
            </p>
            <p className="text-[10px] text-on-surface-variant">Administrator</p>
          </div>
        </div>
        <button
          onClick={handleSignOut}
          className="flex items-center gap-stack-md px-gutter py-stack-md text-on-surface-variant/60 hover:text-error transition-all rounded-xl"
        >
          <span className="material-symbols-outlined">logout</span>
          <span className="font-label-sm text-label-sm">Sign Out</span>
        </button>
      </div>
    </nav>
  );
}
