import { Line } from 'react-chartjs-2';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Filler,
  Tooltip,
  Legend,
} from 'chart.js';
import AdminLayout from '../components/admin/AdminLayout';
import { useDashboardStats, useRecentActivity } from '../hooks/useDashboardData';
import { Link } from 'react-router-dom';

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Filler, Tooltip, Legend);

function StatCard({
  label,
  value,
  icon,
  iconBg,
  trend,
  trendColor,
  subtext,
}: {
  label: string;
  value: string;
  icon: string;
  iconBg: string;
  trend?: string;
  trendColor?: string;
  subtext?: string;
}) {
  return (
    <div className="glass-card p-stack-lg rounded-2xl flex flex-col">
      <div className="flex justify-between items-start mb-stack-md">
        <div>
          <p className="font-label-sm text-label-sm text-on-surface-variant mb-1">{label}</p>
          <h2 className="font-headline-md text-headline-md text-primary">{value}</h2>
        </div>
        <span className={`p-3 ${iconBg} rounded-xl material-symbols-outlined`}>{icon}</span>
      </div>
      {trend && (
        <div className={`flex items-center gap-1 ${trendColor || 'text-vibrant-green'}`}>
          <span className="material-symbols-outlined text-[16px]">trending_up</span>
          <span className="font-label-bold text-label-bold">{trend}</span>
          {subtext && <span className="text-on-surface-variant font-label-sm ml-1">{subtext}</span>}
        </div>
      )}
    </div>
  );
}

export default function Dashboard() {
  const { stats, loading } = useDashboardStats();
  const { activities } = useRecentActivity();

  const chartData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    datasets: [
      {
        label: 'Enrollments',
        data: [0, 0, 0, 0, 0, 0, stats.totalStudents],
        borderColor: '#002045',
        borderWidth: 3,
        pointBackgroundColor: '#48BB78',
        pointBorderColor: '#ffffff',
        pointBorderWidth: 2,
        pointRadius: 6,
        pointHoverRadius: 8,
        fill: true,
        backgroundColor: (ctx: { chart: { ctx: CanvasRenderingContext2D } }) => {
          const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 400);
          gradient.addColorStop(0, 'rgba(0, 32, 69, 0.2)');
          gradient.addColorStop(1, 'rgba(0, 32, 69, 0)');
          return gradient;
        },
        tension: 0.4,
      },
    ],
  };

  const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, grid: { color: 'rgba(203, 213, 225, 0.2)' } },
      x: { grid: { display: false } },
    },
  };

  const colorMap: Record<string, string> = {
    'vibrant-green': 'bg-vibrant-green/10 text-vibrant-green',
    primary: 'bg-primary/10 text-primary',
    'energetic-orange': 'bg-energetic-orange/10 text-energetic-orange',
    'deep-navy': 'bg-deep-navy/10 text-deep-navy',
  };

  return (
    <AdminLayout
      title="Dashboard"
      description="Welcome back. Here's what's happening across your academy."
    >
      {/* Hero Metrics */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-stack-md mb-stack-lg">
        <StatCard
          label="Total Students"
          value={loading ? '—' : String(stats.totalStudents)}
          icon="groups"
          iconBg="bg-secondary-container/30 text-on-secondary-container"
          subtext="enrolled"
        />
        <StatCard
          label="Monthly Revenue"
          value={loading ? '—' : `RM ${stats.totalRevenue.toLocaleString('en-MY', { minimumFractionDigits: 0 })}`}
          icon="payments"
          iconBg="bg-primary-fixed/30 text-primary"
          subtext="from tuition"
        />
        <StatCard
          label="Attendance Rate"
          value={loading ? '—' : `${stats.attendanceRate}%`}
          icon="calendar_today"
          iconBg="bg-tertiary-fixed/30 text-tertiary"
          subtext="overall"
        />
        <StatCard
          label="Active Classrooms"
          value={loading ? '—' : String(stats.activeClassrooms)}
          icon="meeting_room"
          iconBg="bg-on-primary-fixed/10 text-on-primary-fixed"
          subtext={`of ${stats.totalClassrooms} total`}
        />
      </div>

      {/* Bento Grid */}
      <div className="grid grid-cols-12 gap-stack-lg">
        {/* Enrollment Chart */}
        <div className="col-span-12 lg:col-span-8 glass-card p-stack-lg rounded-3xl">
          <div className="flex justify-between items-center mb-stack-lg">
            <h3 className="font-headline-sm text-headline-sm text-primary">Enrollment Trends</h3>
            <select className="bg-surface-container-low border-none rounded-lg text-label-sm font-label-bold px-4 py-2 focus:ring-2 focus:ring-primary outline-none">
              <option>Last 7 Months</option>
              <option>Last Year</option>
            </select>
          </div>
          <div className="h-64 w-full relative">
            <Line data={chartData} options={chartOptions} />
          </div>
        </div>

        {/* Recent Activity */}
        <div className="col-span-12 lg:col-span-4 glass-card p-stack-lg rounded-3xl flex flex-col">
          <div className="flex justify-between items-center mb-stack-lg">
            <h3 className="font-headline-sm text-headline-sm text-primary">Recent Activity</h3>
            <span className="text-on-secondary-container bg-secondary-container px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
              Live
            </span>
          </div>
          <div className="space-y-stack-md overflow-y-auto max-h-[300px] pr-2">
            {activities.length === 0 && (
              <p className="text-on-surface-variant text-body-md">No recent activity.</p>
            )}
            {activities.map((a) => (
              <div key={a.id} className="flex gap-stack-md p-stack-sm rounded-xl hover:bg-primary/5 transition-colors">
                <div
                  className={`w-10 h-10 rounded-full flex items-center justify-center shrink-0 ${colorMap[a.color] || 'bg-primary/10 text-primary'}`}
                >
                  <span className="material-symbols-outlined text-[20px]">{a.icon}</span>
                </div>
                <div>
                  <p className="text-body-md">
                    <span className="font-bold">{a.message}</span>
                  </p>
                  <p className="text-label-sm text-on-surface-variant/70">{a.subtext}</p>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Quick Actions */}
        <div className="col-span-12 grid grid-cols-1 md:grid-cols-3 gap-stack-lg">
          <Link
            to="/forms"
            className="glass-card kinetic-hover p-stack-lg rounded-2xl flex items-center gap-gutter"
          >
            <div className="w-16 h-16 rounded-full bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white shrink-0">
              <span className="material-symbols-outlined text-[32px]">dynamic_form</span>
            </div>
            <div>
              <h4 className="font-label-bold text-label-bold text-primary">Registration Forms</h4>
              <p className="text-label-sm text-on-surface-variant">Create & manage forms</p>
            </div>
          </Link>
          <Link
            to="/classrooms"
            className="glass-card kinetic-hover p-stack-lg rounded-2xl flex items-center gap-gutter"
          >
            <div className="w-16 h-16 rounded-full bg-gradient-to-tr from-energetic-orange to-tertiary-fixed-dim flex items-center justify-center text-white shrink-0">
              <span className="material-symbols-outlined text-[32px]">groups</span>
            </div>
            <div>
              <h4 className="font-label-bold text-label-bold text-primary">Classrooms</h4>
              <p className="text-label-sm text-on-surface-variant">{stats.activeClassrooms} active</p>
            </div>
          </Link>
          <Link
            to="/fees"
            className="glass-card kinetic-hover p-stack-lg rounded-2xl flex items-center gap-gutter"
          >
            <div className="w-16 h-16 rounded-full bg-gradient-to-tr from-deep-navy to-on-primary-container flex items-center justify-center text-white shrink-0">
              <span className="material-symbols-outlined text-[32px]">payments</span>
            </div>
            <div>
              <h4 className="font-label-bold text-label-bold text-primary">Fee Management</h4>
              <p className="text-label-sm text-on-surface-variant">
                RM {stats.outstandingFees.toLocaleString('en-MY', { minimumFractionDigits: 0 })} outstanding
              </p>
            </div>
          </Link>
        </div>
      </div>
    </AdminLayout>
  );
}
