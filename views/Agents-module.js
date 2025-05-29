const API_BASE = 'https://cannigrow.free.nf/managment/api/agentApi.php'; // change as needed

const headers = {
  'Content-Type': 'application/json'
};

// GET all agents or one by ID
export async function getAgents(id = null) {
  const url = id ? `${API_BASE}?id=${id}` : API_BASE;
  const res = await fetch(url);
  return await res.json();
}

// POST: assign areas to agent
export async function assignAreas(areaAssignments = []) {
  const res = await fetch(API_BASE, {
    method: 'POST',
    headers,
    body: JSON.stringify({ areas: areaAssignments })
  });
  return await res.json();
}

// PUT: update agent info
export async function updateAgent(id, name) {
  const res = await fetch(API_BASE, {
    method: 'PUT',
    headers,
    body: JSON.stringify({ id, name })
  });
  return await res.json();
}

// DELETE: remove agent
export async function deleteAgent(id) {
  const res = await fetch(API_BASE, {
    method: 'DELETE',
    headers,
    body: `id=${encodeURIComponent(id)}`
  });
  return await res.json();
}
