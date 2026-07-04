import { useAuth } from '../../context/AuthContext';

export default function TopBar() {
  const { profile } = useAuth();
  const initials = profile?.full_name
    ? profile.full_name.split(' ').map((p) => p[0]).slice(0, 2).join('').toUpperCase()
    : 'A';

  return (
    <header className="flex justify-between items-center px-gutter h-16 w-full sticky top-0 z-40 bg-surface/80 backdrop-blur-md border-b border-glass-border">
      <div className="flex items-center gap-stack-md w-1/3">
        <div className="relative w-full max-w-sm">
          <span className="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-md">
            search
          </span>
          <input
            className="w-full bg-surface-container-low border-none rounded-full pl-10 pr-4 py-2 focus:ring-2 focus:ring-vibrant-green text-body-md outline-none"
            placeholder="Search data, students, classes..."
            type="text"
          />
        </div>
      </div>
      <div className="flex items-center gap-stack-md">
        <button className="relative p-2 text-on-surface-variant hover:text-energetic-orange transition-colors">
          <span className="material-symbols-outlined">notifications</span>
          <span className="absolute top-1.5 right-1.5 w-2 h-2 bg-energetic-orange rounded-full border-2 border-surface" />
        </button>
        <div className="h-8 w-px bg-glass-border mx-2" />
        <div className="flex items-center gap-stack-sm">
          <span className="font-label-bold text-label-bold text-primary hidden sm:inline">
            {profile?.full_name || 'Admin'}
          </span>
          <div className="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold border-2 border-primary/20">
            {initials}
          </div>
        </div>
      </div>
    </header>
  );
}
