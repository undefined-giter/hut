<template>
    <div class="min-h-screen flex flex-col bg-gray-100">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div>
                    <Link href="/" :class="isActive('/') ? 'text-green-500' : 'text-gray-700 hover:text-blue-500'">
                        Accueil
                    </Link>
                </div>

                <nav class="space-x-4">
                    <Link href="/reserver" :class="isActive('/reserver') ? 'text-green-500' : 'text-gray-700 hover:text-blue-500'">
                        Réserver
                    </Link>

                    <template v-if="!auth.user">
                        <Link href="/login" :class="isActive('/login') ? 'text-green-500' : 'text-gray-700 hover:text-blue-500'">
                            Login
                        </Link>
                        <Link href="/register" :class="isActive('/register') ? 'text-green-500' : 'text-gray-700 hover:text-blue-500'">
                            Register
                        </Link>
                    </template>

                    <template v-else>
                        <button @click="logout" class="text-gray-700 hover:text-blue-500">Logout</button>
                        <Link v-if="auth.user.role === 'admin'" href="/list" :class="isActive('/admin') ? 'text-green-500' : 'text-gray-700 hover:text-blue-500'">
                            Admin
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>

        <footer class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 text-center text-gray-500">
                &copy; {{ new Date().getFullYear() }} - Your Company
            </div>
        </footer>
    </div>
</template>

<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const { auth } = usePage().props;

const isActive = (path) => {
    return window.location.pathname === path;
};

const logout = () => {
    Inertia.post('/logout');
};
</script>
