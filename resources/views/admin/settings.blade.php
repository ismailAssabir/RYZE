@extends('admin.layout')
@section('admin')
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black">Settings</h1>
            <p class="mt-2 text-zinc-600 dark:text-zinc-300">Paramètres professionnels pour le dashboard (SEO, PWA, paiement, langues...).</p>
        </div>
        <div class="rounded-lg bg-cyan-500/15 px-4 py-2 text-sm font-semibold text-cyan-700 dark:text-cyan-200">Admin</div>
    </div>

    <section class="mt-6 grid gap-4 md:grid-cols-2">
        <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-950">
            <h2 class="text-lg font-bold">SEO</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Gérez les métadonnées et les règles d’indexation via la config et .env.</p>
            <ul class="mt-3 list-disc pl-5 text-sm text-zinc-600 dark:text-zinc-300">
                <li>Titles & descriptions</li>
                <li>Robots / sitemaps</li>
                <li>Canonical</li>
            </ul>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-950">
            <h2 class="text-lg font-bold">PWA</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Activez/ajustez l’expérience hors-ligne et l’installabilité.</p>
            <ul class="mt-3 list-disc pl-5 text-sm text-zinc-600 dark:text-zinc-300">
                <li>Manifest</li>
                <li>Service worker</li>
                <li>Cache strategies</li>
            </ul>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-950">
            <h2 class="text-lg font-bold">Paiement</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Configurez vos clés et transporteurs de paiement.</p>
            <ul class="mt-3 list-disc pl-5 text-sm text-zinc-600 dark:text-zinc-300">
                <li>Provider keys</li>
                <li>Webhooks</li>
                <li>Mode sandbox/production</li>
            </ul>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-950">
            <h2 class="text-lg font-bold">Langues & Notifications</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Gestion des locales et de la messagerie transactionnelle.</p>
            <ul class="mt-3 list-disc pl-5 text-sm text-zinc-600 dark:text-zinc-300">
                <li>Locales</li>
                <li>Email templates</li>
                <li>Notifs admin</li>
            </ul>
        </div>
    </section>

    <section class="mt-6 rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-950">
        <h2 class="text-lg font-bold">Note</h2>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">
            Cette page est un placeholder UI. Les paramètres réels sont à brancher sur vos configs Laravel / services.
        </p>
    </section>
@endsection

