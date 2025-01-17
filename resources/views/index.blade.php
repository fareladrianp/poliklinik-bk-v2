@extends('layout.template')


<div class="bg-slate-400 h-full">
    <div class=" bg-blue-600 text-white pb-48">
        <h1 class="pt-6 pl-28">Poliklinik</h1>
        <div class="flex justify-center mt-24">
            <p class="text-5xl">Sistem Temu Janji Dokter</p>
        </div>
        <div class="flex justify-center mt-7">
            <p class="text-slate-300 text-xm">Bimbingan Karir - A11.2021.13399</p>
        </div>
    </div>
    <div class="flex justify-center m-7">
        <div class="max-w-96 rounded-2xl shadow-cyan-400 overflow-hidden shadow-2xl bg-white mb-14 mr-12">
            <div class="px-6 py-4">
            <div class="font-bold text-xl mb-3">Registrasi Sebagai Pasien</div>
            <p class="text-gray-700 text-sm">
                Apabila Anda adalah Pasien, silahkan Registrasi terlebih dahulu untuk melakukan pendaftaran sebagai Pasien.
            </p>
            </div>
            <div class="flex px-6 mb-5 justify-center">
                <a href="{{ route('register.pasien')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Registrasi</a>
            </div>
        </div>
        <div class="max-w-96 rounded-2xl shadow-cyan-400 overflow-hidden shadow-2xl bg-white mb-14 ml-12">
            <div class="px-6 py-4">
            <div class="font-bold text-xl mb-3">Masuk Sebagai Dokter</div>
            <p class="text-gray-700 text-sm">
                Apabila Anda adalah Pasien, silahkan Registrasi terlebih dahulu untuk melakukan pendaftaran sebagai Pasien.
            </p>
            </div>
            <div class="flex px-6 mb-5 justify-center">
                <a href="{{ route('login')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Masuk</a>
            </div>
        </div>
    </div>
</div>