<template>
    <footer>
        <div class="meta">
            <h1>مگ مگ</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, neque error! Atque dignissimos voluptate dolores? Officia consequuntur optio eligendi voluptatem rem nesciunt ex minus nemo, dolores cumque autem. Consequatur, quibusdam.</p>
        </div>
        <nav>
            <ul>
                <li>
                    <Link href="/">خانه</Link>
                </li>
                <li>
                    <Link href="/posts">پست ها</Link>
                </li>
                <li></li>
            </ul>
        </nav>
    </footer>
</template>
<style scoped>
footer {
    @apply bg-slate-900 text-gray-100 flex flex-col md:flex-row md:justify-between gap-8
}

footer h1 {
    @apply text-lg
}

footer .meta {
    @apply w-full md:w-1/3
}

footer nav {
    @apply w-full md:w-2/3
}
</style>