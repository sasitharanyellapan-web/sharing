import { type ReactNode } from 'react';
import Sidebar from './Sidebar';
import TopBar from './TopBar';

interface AdminLayoutProps {
  children: ReactNode;
  breadcrumb?: { label: string; to?: string }[];
  title: string;
  description?: string;
  actions?: ReactNode;
}

export default function AdminLayout({
  children,
  breadcrumb,
  title,
  description,
  actions,
}: AdminLayoutProps) {
  return (
    <>
      <Sidebar />
      <main className="ml-72 min-h-screen flex flex-col">
        <TopBar />
        <div className="flex-grow p-gutter max-w-container-max mx-auto w-full">
          {breadcrumb && breadcrumb.length > 0 && (
            <div className="flex items-center gap-2 mb-4 text-label-sm text-on-surface-variant">
              {breadcrumb.map((bc, i) => (
                <span key={i} className="flex items-center gap-2">
                  {i > 0 && <span className="material-symbols-outlined text-[16px]">chevron_right</span>}
                  <span className={i === breadcrumb.length - 1 ? 'text-primary font-bold' : ''}>
                    {bc.label}
                  </span>
                </span>
              ))}
            </div>
          )}
          <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-stack-lg">
            <div>
              <h1 className="text-display-lg-mobile md:text-headline-md font-headline-md text-primary mb-2">
                {title}
              </h1>
              {description && <p className="text-body-md text-on-surface-variant">{description}</p>}
            </div>
            {actions && <div className="flex items-center gap-stack-md flex-wrap">{actions}</div>}
          </div>
          {children}
        </div>
        <footer className="mt-auto border-t border-glass-border/50 py-stack-md px-gutter w-full flex justify-between items-center text-on-surface-variant/60 font-label-sm text-label-sm">
          <span>© 2026 Code Geek Academy | Management Portal</span>
          <div className="flex gap-stack-lg">
            <a className="hover:text-vibrant-green transition-colors" href="#">Privacy Policy</a>
            <a className="hover:text-vibrant-green transition-colors" href="#">Terms of Service</a>
          </div>
        </footer>
      </main>
    </>
  );
}
