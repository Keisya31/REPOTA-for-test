<nav class="bg-white dark:bg-gray-900 w-full fixed top-12 z-10">
<div class="max-w-screen-xl flex items-center h-10 justify-center mx-auto">
  <div class="items-center justify-center hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <ul class="flex items-center gap-5 p-4 md:p-0 font-normal text-sm">
      <li>
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-orange-500 md:p-0 md:dark:hover:text-orange-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 hover:-translate-y-2 hover:text-lg duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-[#FF5722] font-bold' : 'text-[#121435]' }}">Kelola Skripsi</a>
      </li>
      <li>
        <a href="{{ route('admin.kelola-mahasiswa') }}" class="block py-2 px-3 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-orange-500 md:p-0 md:dark:hover:text-orange-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 hover:-translate-y-2 hover:text-lg duration-200 {{ request()->routeIs('admin.kelola-mahasiswa') ? 'text-[#FF5722] font-bold' : 'text-[#121435]' }}">Data Mahasiswa</a>
      </li>
      <li>
        <a href="{{ route('forum') }}" class="block py-2 px-3  rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-orange-500 md:p-0 md:dark:hover:text-orange-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 hover:-translate-y-2 hover:text-lg duration-200 {{ request()->routeIs('forum') ? ' text-[#FF5722] font-bold' : 'text-[#121435]' }}">Forum Diskusi</a>
      </li>
      <li>
        <a href="{{ route('base') }}" class="block py-2 px-3 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-orange-500 md:p-0 md:dark:hover:text-orange-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 hover:-translate-y-2 hover:text-lg duration-200 {{ request()->routeIs('base') ? 'text-[#FF5722] font-bold' : 'text-[#121435]' }}">Cari Skripsi</a>
      </li>
    </ul>
  </div>
</div>
</nav>
