@extends('layout.template')

<div class="bg-slate-200 pt-0.5 pb-60">
    <div class="flex justify-center mt-36">
        <div class="w-full max-w-xs ">
                <form action="{{ route('login.pasien.submit') }}" class="bg-white shadow-2xl rounded-xl px-8 pt-6 pb-8 mb-4" method="post">
                  @csrf
                    <h1 class="flex justify-center font-bold text-3xl mb-5">Login Pasien</h1>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                      Nama
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nama" id="username" type="text" placeholder="Nama">
                  </div>
                  <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                      Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="alamat" id="password" type="password" placeholder="Password">
                    @if (session('error'))
                      <div style="color: red;" class="flex justify-center">
                          {{ session('error') }}
                      </div>
                    @endif
                  </div>
                  <div class="flex items-center justify-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                      Masuk
                    </button>
                  </div>
                  <div class="flex justify-center gap-2 mt-10">
                    <a href="{{route('index')}}"
                        class="inline-flex items-center border-2 shadow-xl px-3 py-1.5 rounded-md text-gray-500 hover:bg-indigo-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18">
                            </path>
                        </svg>
                        <span class="ml-1 font-bold text-lg"></span>
                    </a>
                </div>
                </form>
        </div>
    </div>
</div>