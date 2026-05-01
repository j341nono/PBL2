import { getIronSession } from 'iron-session';
import { sessionOptions } from '../../lib/session';
import { getDb } from '../../lib/db';
import Head from 'next/head';
import Link from 'next/link';
import { useRouter } from 'next/router';
import { useEffect } from 'react';

export async function getServerSideProps({ req, res, query }) {
  const session = await getIronSession(req, res, sessionOptions);
  if (!session.userId) {
    return { redirect: { destination: '/login', permanent: false } };
  }
  const period = ['daily', 'weekly', 'monthly'].includes(query.period) ? query.period : 'daily';
  const sort = ['taskID', 'startdate', 'enddate'].includes(query.sort) ? query.sort : 'taskID';
  const db = getDb();
  const [tasks] = await db.query(
    `SELECT taskID, todolist, addgold, startdate, enddate, period
     FROM UserTasks2 WHERE userID = ? AND period = ? ORDER BY ${sort}`,
    [session.userId, period]
  );
  return {
    props: {
      tasks: tasks.map(t => ({
        taskID: t.taskID,
        todolist: t.todolist,
        addgold: t.addgold,
        startdate: t.startdate ? String(t.startdate).split('T')[0] : '',
        enddate: t.enddate ? String(t.enddate).split('T')[0] : '',
        period: t.period,
      })),
      currentPeriod: period,
      currentSort: sort,
    },
  };
}

export default function TasksPage({ tasks, currentPeriod, currentSort }) {
  const router = useRouter();

  useEffect(() => {
    const images = ['/game/hero_left.PNG', '/game/hero_straight.PNG', '/game/hero_right.PNG'];
    let idx = 0;
    const timer = setInterval(() => {
      const el = document.getElementById('animatedImage');
      if (el) { idx = (idx + 1) % images.length; el.src = images[idx]; }
    }, 150);
    return () => clearInterval(timer);
  }, []);

  async function handleAction(taskId, action) {
    const endpoint = action === 'delete' ? '/api/tasks/delete' : '/api/tasks/complete';
    const res = await fetch(endpoint, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ taskIDs: [String(taskId)] }),
    });
    const json = await res.json();
    if (res.ok) {
      if (action === 'complete') alert(`${json.gold}G を獲得！`);
    } else {
      alert(json.error || 'エラーが発生しました');
    }
    router.replace(router.asPath);
  }

  async function handleBulkComplete() {
    const checked = Array.from(document.querySelectorAll('input[name="taskID"]:checked')).map(el => el.value);
    if (!checked.length) { alert('タスクを選択してください'); return; }
    const res = await fetch('/api/tasks/complete', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ taskIDs: checked }),
    });
    const json = await res.json();
    if (res.ok) { alert(`${json.gold}G を獲得！`); router.replace(router.asPath); }
    else alert(json.error || 'エラー');
  }

  return (
    <>
      <Head>
        <title>Task Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
      </Head>
      <div className="container" style={{ maxWidth: 900, marginTop: 30 }}>
        <div style={{ backgroundColor: 'white', boxShadow: '0 4px 6px rgba(0,0,0,0.1)', borderRadius: 10, padding: 30 }}>
          <div style={{ backgroundColor: '#2c3e50', color: 'white', padding: 15, borderRadius: 5, marginBottom: 20, textAlign: 'center' }}>
            <h1 style={{ margin: 0, fontSize: 24 }}>
              Task Management Dashboard&nbsp;
              <img id="animatedImage" src="/game/hero_left.PNG" style={{ width: 60, height: 60, verticalAlign: 'middle' }} alt="" />
            </h1>
          </div>

          <ul className="nav nav-tabs mb-4">
            {['daily', 'weekly', 'monthly'].map(p => (
              <li className="nav-item" key={p}>
                <Link
                  href={`/tasks?period=${p}`}
                  className="nav-link"
                  style={currentPeriod === p
                    ? { backgroundColor: '#3498db', color: 'white', fontWeight: 'bold' }
                    : { color: '#2c3e50', fontWeight: 'bold' }
                  }
                >
                  {p.charAt(0).toUpperCase() + p.slice(1)} Tasks
                </Link>
              </li>
            ))}
          </ul>

          <div className="mb-3">
            <select
              className="form-select"
              style={{ width: 220 }}
              value={currentSort}
              onChange={e => router.push(`/tasks?period=${currentPeriod}&sort=${e.target.value}`)}
            >
              <option value="taskID">Sort by Task ID</option>
              <option value="startdate">Sort by Start Date</option>
              <option value="enddate">Sort by End Date</option>
            </select>
          </div>

          {tasks.length > 0 ? (
            <div className="table-responsive">
              <table className="table table-hover">
                <thead>
                  <tr>
                    <th>
                      <input type="checkbox" id="selectAll" onChange={e => {
                        document.querySelectorAll('input[name="taskID"]').forEach(cb => { cb.checked = e.target.checked; });
                      }} />
                    </th>
                    <th>Task</th>
                    <th>Gold</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  {tasks.map(task => (
                    <tr key={task.taskID}>
                      <td><input type="checkbox" name="taskID" value={String(task.taskID)} /></td>
                      <td>{task.todolist}</td>
                      <td>{task.addgold}G</td>
                      <td>{task.startdate}</td>
                      <td>{task.enddate}</td>
                      <td>
                        <div style={{ display: 'flex', gap: 8 }}>
                          <button
                            className="btn btn-sm btn-danger"
                            onClick={() => handleAction(task.taskID, 'delete')}
                            title="Delete"
                          >
                            <i className="fas fa-trash-alt" />
                          </button>
                          <button
                            className="btn btn-sm btn-success"
                            onClick={() => handleAction(task.taskID, 'complete')}
                            title="Complete"
                          >
                            <i className="fas fa-check-circle" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          ) : (
            <div className="alert alert-info">No tasks found for this period.</div>
          )}

          <div className="mt-4 d-flex gap-2 justify-content-center flex-wrap">
            <Link href="/tasks/add" className="btn btn-primary">
              <i className="fas fa-plus-circle me-2" />Add New Task
            </Link>
            <button className="btn btn-success" onClick={handleBulkComplete}>
              <i className="fas fa-check me-2" />Complete Selected
            </button>
            <Link href="/homepage" className="btn btn-secondary">
              <i className="fas fa-home me-2" />Back to Home
            </Link>
          </div>
        </div>
      </div>
    </>
  );
}
