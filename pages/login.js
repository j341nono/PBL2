import { useState } from 'react';
import { useRouter } from 'next/router';
import Link from 'next/link';

export default function LoginPage() {
  const router = useRouter();
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);
    setError('');
    const data = new FormData(e.target);
    const res = await fetch('/api/auth/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        userID: data.get('userID'),
        password: data.get('password'),
      }),
    });
    const json = await res.json();
    if (res.ok) {
      router.push('/homepage');
    } else {
      setError(json.error || 'ログイン失敗');
      setLoading(false);
    }
  }

  return (
    <div className="auth-container">
      <h2>ログイン</h2>
      {error && <p className="error-msg">{error}</p>}
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="userID">ユーザーID</label>
          <input type="number" id="userID" name="userID" required />
        </div>
        <div className="form-group">
          <label htmlFor="password">パスワード</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit" className="btn btn-primary" disabled={loading}>
          {loading ? 'ログイン中...' : 'ログイン'}
        </button>
      </form>
      <p className="text-center mt-3">
        <Link href="/register">新規登録はこちら</Link>
      </p>
    </div>
  );
}
