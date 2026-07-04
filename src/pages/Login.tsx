import { useState, type FormEvent } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

export default function Login() {
  const { signIn } = useAuth();
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();
    setError(null);
    setLoading(true);
    const { error } = await signIn(email, password);
    setLoading(false);
    if (error) {
      setError(error);
    } else {
      navigate('/');
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center gradient-mesh p-4">
      <div className="fixed top-[-10%] right-[-10%] w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] -z-10 pointer-events-none" />
      <div className="fixed bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-secondary/5 rounded-full blur-[100px] -z-10 pointer-events-none" />

      <div className="glass-card w-full max-w-md rounded-3xl p-gutter">
        <div className="flex flex-col items-center mb-stack-lg">
          <div className="w-16 h-16 rounded-2xl bg-primary flex items-center justify-center text-on-primary font-bold text-2xl mb-4">
            CG
          </div>
          <h1 className="font-headline-md text-headline-md font-bold text-primary text-center">
            Code Geek Admin
          </h1>
          <p className="text-body-md text-on-surface-variant text-center mt-1">
            Sign in to the Management Portal
          </p>
        </div>

        {error && (
          <div className="bg-error-container/60 text-error px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <span className="material-symbols-outlined">error</span>
            <span className="text-body-md">{error}</span>
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block font-label-bold text-label-bold text-primary mb-2">Email</label>
            <input
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
              className="input-field"
              placeholder="admin@codegeekacademy.com.my"
            />
          </div>
          <div>
            <label className="block font-label-bold text-label-bold text-primary mb-2">Password</label>
            <input
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
              className="input-field"
              placeholder="••••••••"
            />
          </div>
          <button
            type="submit"
            disabled={loading}
            className="btn-primary w-full justify-center disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {loading ? (
              <>
                <span className="material-symbols-outlined animate-spin">progress_activity</span>
                Signing in...
              </>
            ) : (
              <>
                <span className="material-symbols-outlined">login</span>
                Sign In
              </>
            )}
          </button>
        </form>

        <p className="text-center text-label-sm text-on-surface-variant mt-6">
          Need an admin account?{' '}
          <button onClick={() => navigate('/signup')} className="text-primary font-label-bold hover:underline">
            Create one
          </button>
        </p>
      </div>
    </div>
  );
}
