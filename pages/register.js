import { useState } from 'react';
import { useRouter } from 'next/router';
import Link from 'next/link';

export default function RegisterPage() {
  const router = useRouter();
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function handleSubmit(e) {
    e.preventDefault();
    const data = new FormData(e.target);
    const name = data.get('name');
    const pass = data.get('pass');
    const pass2 = data.get('pass2');

    if (!name) { setError('ユーザー名が入力されていません'); return; }
    if (!pass) { setError('パスワードが入力されていません'); return; }
    if (pass !== pass2) { setError('パスワードが一致しません'); return; }

    setLoading(true);
    setError('');
    const res = await fetch('/api/auth/register', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, password: pass }),
    });
    const json = await res.json();
    if (res.ok) {
      alert(`登録完了！ユーザーIDは ${json.userId} です。\nメモしてください。`);
      router.push('/login');
    } else {
      setError(json.error || '登録失敗');
      setLoading(false);
    }
  }

  return (
    <div className="auth-container">
      <h2>新規登録</h2>
      {error && <p className="error-msg">{error}</p>}
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>ユーザー名</label>
          <input type="text" name="name" required />
        </div>
        <div className="form-group">
          <label>パスワード</label>
          <input type="password" name="pass" required />
        </div>
        <div className="form-group">
          <label>パスワード（確認）</label>
          <input type="password" name="pass2" required />
        </div>
        <button type="submit" className="btn btn-primary" disabled={loading}>
          {loading ? '登録中...' : '登録'}
        </button>
      </form>
      <p className="text-center mt-3">
        <Link href="/login">ログインページへ</Link>
      </p>
    </div>
  );
}
