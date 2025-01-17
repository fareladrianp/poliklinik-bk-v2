@extends('layout.template')

<div class="bg-slate-200 pt-0.5 pb-28">
    <div class="flex justify-center mt-20">
        <div class="w-full max-w-xs ">
                <form action="{{ route('register.pasien.submit') }}" class="bg-white shadow-2xl rounded-xl px-8 pt-6 pb-8 mb-4" method="post">
                  @csrf
                    <h1 class="flex justify-center font-bold text-3xl mb-5">Registrasi Pasien</h1>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">
                      Nama
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nama" id="username" type="text" placeholder="Nama">
                  </div>
                  @error('nama')
                  <div class="text-red-600">
                    {{$message}}
                  </div>
                    
                  @enderror
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat">
                      Alamat
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="alamat" id="username" type="text" placeholder="Alamat">
                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ktp">
                      No. KTP
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="ktp" id="username" type="text">
                  </div>
                  <div class="mb-7">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="no.hp">
                      No. Handphone
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nohp" id="username" type="text">
                  </div>
                  <div class="flex items-center justify-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                      Daftar
                    </button>
                  </div>
                  <div class="flex items-center text-xs justify-center pt-4 text-blue-700">
                    <a href="{{ route('login.pasien') }}">Sudah memiliki Akun?</a>
                  </div>
                </form>
        </div>
    </div>
</div>
