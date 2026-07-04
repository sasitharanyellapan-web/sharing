interface StatusBadgeProps {
  status: string;
}

const statusConfig: Record<string, { bg: string; text: string; dot: string; label?: string }> = {
  pending: { bg: 'bg-tertiary-fixed/40', text: 'text-energetic-orange', dot: 'bg-energetic-orange' },
  approved: { bg: 'bg-secondary-container/40', text: 'text-secondary', dot: 'bg-secondary' },
  paid: { bg: 'bg-secondary-container/40', text: 'text-secondary', dot: 'bg-secondary' },
  present: { bg: 'bg-secondary-container/40', text: 'text-secondary', dot: 'bg-secondary' },
  rejected: { bg: 'bg-error-container/60', text: 'text-error', dot: 'bg-error' },
  overdue: { bg: 'bg-error-container/60', text: 'text-error', dot: 'bg-error' },
  absent: { bg: 'bg-error-container/60', text: 'text-error', dot: 'bg-error' },
  outstanding: { bg: 'bg-tertiary-fixed/40', text: 'text-energetic-orange', dot: 'bg-energetic-orange' },
  excused: { bg: 'bg-tertiary-fixed/40', text: 'text-energetic-orange', dot: 'bg-energetic-orange' },
  waitlisted: { bg: 'bg-surface-container-high', text: 'text-on-surface-variant', dot: 'bg-on-surface-variant' },
  active: { bg: 'bg-secondary-container/40', text: 'text-secondary', dot: 'bg-secondary' },
  inactive: { bg: 'bg-surface-container-high', text: 'text-on-surface-variant', dot: 'bg-on-surface-variant' },
  scheduled: { bg: 'bg-tertiary-fixed/40', text: 'text-energetic-orange', dot: 'bg-energetic-orange' },
  verified: { bg: 'bg-secondary-container/40', text: 'text-secondary', dot: 'bg-secondary' },
};

export default function StatusBadge({ status }: StatusBadgeProps) {
  const cfg = statusConfig[status] || statusConfig.pending;
  return (
    <span className={`status-badge ${cfg.bg} ${cfg.text}`}>
      <span className={`w-1.5 h-1.5 rounded-full ${cfg.dot}`} />
      {cfg.label || status}
    </span>
  );
}
