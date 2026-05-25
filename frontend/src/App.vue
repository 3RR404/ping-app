<template>
  <div class="wrapper">
    <form class="card" @submit.prevent="send">
      <h1>Ping</h1>

      <div class="field">
        <label for="uuid">UUID</label>
        <input
          id="uuid"
          v-model="form.uuid"
          type="text"
          placeholder="e.g. device-abc-123"
          required
        />
      </div>

      <div class="field">
        <label for="battery">Battery %</label>
        <input
          id="battery"
          v-model.number="form.battery_percent"
          type="number"
          min="0"
          max="100"
          step="0.1"
          placeholder="0 – 100"
          required
        />
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Sending…' : 'Send' }}
      </button>

      <p v-if="status === 'ok'" class="msg ok">Sent successfully.</p>
      <p v-else-if="status === 'error'" class="msg error">Something went wrong.</p>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'

const form = reactive({ uuid: '', battery_percent: '' })
const loading = ref(false)
const status = ref(null)

async function send() {
  loading.value = true
  status.value = null
  try {
    const res = await fetch('/api/ping', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form),
    })
    status.value = res.ok ? 'ok' : 'error'
  } catch {
    status.value = 'error'
  } finally {
    loading.value = false
  }
}
</script>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: system-ui, sans-serif;
  background: #f1f5f9;
  min-height: 100vh;
  display: grid;
  place-items: center;
}

.wrapper {
  width: 100%;
  padding: 1rem;
}

.card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 16px rgba(0,0,0,.08);
  padding: 2rem;
  max-width: 400px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

h1 {
  font-size: 1.4rem;
  font-weight: 600;
  color: #0f172a;
}

.field {
  display: flex;
  flex-direction: column;
  gap: .4rem;
}

label {
  font-size: .85rem;
  font-weight: 500;
  color: #475569;
}

input {
  padding: .6rem .8rem;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 1rem;
  outline: none;
  transition: border-color .15s;
}

input:focus { border-color: #6366f1; }

button {
  padding: .7rem;
  background: #6366f1;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: background .15s;
}

button:hover:not(:disabled) { background: #4f46e5; }
button:disabled { opacity: .6; cursor: not-allowed; }

.msg { font-size: .9rem; text-align: center; }
.ok    { color: #16a34a; }
.error { color: #dc2626; }
</style>
