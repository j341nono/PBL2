import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../lib/session';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useState, useEffect } from 'react';

export async function getServerSideProps({ req, res }) {
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) return { redirect: { destination: '/login', permanent: false } };
  return { props: {} };
}

const GOLD_OPTIONS = {
  daily: [100, 200, 300],
  weekly: [700, 800, 900],
  monthly: [1500, 1600, 1700],
};

export default function AddTaskPage() {
  const router = useRouter();
  const [period, setPeriod] = useState('daily');
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');

  useEffect(() => {
    const images = ['/game/hero_left.PNG', '/game/hero_straight.PNG', '/game/hero_right.PNG'];
    let idx = 0;
    const timer = setInterval(() => {
      const el = document.getElementById('animatedImage');
      if (el) { idx = (idx + 1) % images.length; el.src = images[idx]; }
    }, 150);
    return () => clearInterval(timer);
  }, []);

  async function handleSubmit(e) {
    e.preventDefault();
    setError('');
    setMessage('');
    const data = new FormData(e.target);
    const startdate = data.get('startdate');
    const enddate = data.get('enddate');
    if (new Date(enddate) <= new Date(startdate)) {
      setError('終了日は開始日より後の日付にしてください');
      return;
    }
    const res = await fetch('/api/tasks/add', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        todolist: data.get('todolist'),
        addgold: Number(data.get('addgold')),
        startdate,
        enddate,
        period: data.get('period'),
      }),
    });
    const json = await res.json();
    if (res.ok) {
      setMessage('タスクを追加しました');
      e.target.reset();
      setPeriod('daily');
    } else {
      setError(json.error || 'エラーが発生しました');
    }
  }

  return (
    <>
      <Head>
        <title>Add Task</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
      </Head>
      <div className="container" style={{ maxWidth: 600, marginTop: 30 }}>
        <div style={{ backgroundColor: 'white', boxShadow: '0 4px 6px rgba(0,0,0,0.1)', borderRadius: 10, padding: 30 }}>
          <div style={{ backgroundColor: '#2c3e50', color: 'white', padding: 15, borderRadius: 5, marginBottom: 20, textAlign: 'center' }}>
            <h1 style={{ margin: 0, fontSize: 24 }}>
              Add New Task&nbsp;
              <img id="animatedImage" src="/game/hero_left.PNG" style={{ width: 60, height: 60, verticalAlign: 'middle' }} alt="" />
            </h1>
          </div>

          {message && <div className="alert alert-success">{message}</div>}
          {error && <div className="alert alert-danger">{error}</div>}

          <form onSubmit={handleSubmit}>
            <div className="mb-3">
              <label className="form-label fw-bold">Task Description</label>
              <input type="text" className="form-control" name="todolist" required />
            </div>
            <div className="mb-3">
              <label className="form-label fw-bold">Period</label>
              <select
                className="form-select"
                name="period"
                value={period}
                onChange={e => setPeriod(e.target.value)}
                required
              >
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
              </select>
            </div>
            <div className="mb-3">
              <label className="form-label fw-bold">Gold Reward</label>
              <select className="form-select" name="addgold" required>
                {GOLD_OPTIONS[period].map(v => <option key={v} value={v}>{v}G</option>)}
              </select>
            </div>
            <div className="row mb-3">
              <div className="col-md-6">
                <label className="form-label fw-bold">Start Date</label>
                <input type="date" className="form-control" name="startdate" required />
              </div>
              <div className="col-md-6">
                <label className="form-label fw-bold">End Date</label>
                <input type="date" className="form-control" name="enddate" required />
              </div>
            </div>
            <div className="d-flex gap-2 justify-content-center mt-4">
              <button type="submit" className="btn btn-primary">
                <i className="fas fa-plus-circle me-2" />Add Task
              </button>
              <Link href="/tasks" className="btn btn-secondary">
                <i className="fas fa-list me-2" />Back to Tasks
              </Link>
            </div>
          </form>
        </div>
      </div>
    </>
  );
}
