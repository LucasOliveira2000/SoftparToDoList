<template>
    <q-layout view="hHh lpR fFf" class="bg-gray-900">
      <!-- Cabeçalho -->
      <q-header elevated>
        <q-toolbar>
          <q-btn
            flat
            dense
            round
            icon="menu"
            @click="showingNavigationDropdown = !showingNavigationDropdown"
            aria-label="Menu"
          />

          <q-toolbar-title>
            <Link :href="route('dashboard')">
              <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
            </Link>
          </q-toolbar-title>

          <q-btn
            flat
            dense
            round
            icon="account_circle"
            @click="showingNavigationDropdown = !showingNavigationDropdown"
            aria-label="Account"
          />
        </q-toolbar>
      </q-header>

      <!-- Menu lateral (Drawer) -->
      <q-drawer v-model="showingNavigationDropdown" side="left" bordered>
        <q-list>
          <!-- Links no menu lateral -->
          <Link :href="route('dashboard')" class="q-item q-item-type row no-wrap q-item--clickable q-link">
            <q-item-section avatar>
              <q-icon name="dashboard" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Dashboard</q-item-label>
            </q-item-section>
          </Link>

          <Link :href="route('categoria.index')" class="q-item q-item-type row no-wrap q-item--clickable q-link">
            <q-item-section avatar>
              <q-icon name="category" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Categoria</q-item-label>
            </q-item-section>
          </Link>

          <Link :href="route('tarefa.index')" class="q-item q-item-type row no-wrap q-item--clickable q-link">
            <q-item-section avatar>
              <q-icon name="task" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Tarefa</q-item-label>
            </q-item-section>
          </Link>

          <!-- Link de Logout -->
          <form @submit.prevent="logout" class="q-item q-item-type row no-wrap q-item--clickable q-link">
            <q-item-section avatar>
              <q-icon name="logout" />
            </q-item-section>
            <q-item-section>
              <q-item-label>
                <button type="submit" class="text-left w-full">Logout</button>
              </q-item-label>
            </q-item-section>
          </form>
        </q-list>
      </q-drawer>

      <!-- Conteúdo da página -->
      <q-page-container>
        <q-page>
            
          <slot />
        </q-page>
      </q-page-container>

      <Toast />
    </q-layout>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { Link } from '@inertiajs/vue3';
  import ApplicationLogo from '@/Components/ApplicationLogo.vue';
  import { Inertia } from '@inertiajs/inertia';
  import Toast from '@/Components/Toast.vue';

  const showingNavigationDropdown = ref(false);

  const logout = () => {
    Inertia.post(route('profile.logout'));
  };
  </script>
