import { type ReactNode, useEffect } from 'react';

interface ModalProps {
  open: boolean;
  onClose: () => void;
  title: string;
  children: ReactNode;
  footer?: ReactNode;
  maxWidth?: string;
}

export default function Modal({ open, onClose, title, children, footer, maxWidth = 'max-w-2xl' }: ModalProps) {
  useEffect(() => {
    if (open) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
    return () => {
      document.body.style.overflow = '';
    };
  }, [open]);

  if (!open) return null;

  return (
    <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-primary/40 backdrop-blur-sm">
      <div
        className={`glass-card ${maxWidth} w-full rounded-3xl max-h-[90vh] overflow-y-auto`}
        style={{ background: 'rgba(255,255,255,0.95)' }}
      >
        <div className="sticky top-0 bg-primary text-on-primary px-gutter py-stack-md flex items-center justify-between rounded-t-3xl z-10">
          <h2 className="font-headline-sm text-headline-sm font-bold">{title}</h2>
          <button
            onClick={onClose}
            className="p-1 hover:bg-white/10 rounded-lg transition-colors"
          >
            <span className="material-symbols-outlined">close</span>
          </button>
        </div>
        <div className="p-gutter">{children}</div>
        {footer && (
          <div className="sticky bottom-0 bg-surface-container-low/80 backdrop-blur-md px-gutter py-stack-md flex items-center justify-end gap-stack-md rounded-b-3xl border-t border-glass-border">
            {footer}
          </div>
        )}
      </div>
    </div>
  );
}
