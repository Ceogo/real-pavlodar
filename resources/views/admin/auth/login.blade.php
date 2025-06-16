<!DOCTYPE html>
   <html lang="ru">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Вход</title>
       <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   </head>
   <body class="bg-gray-100 flex items-center justify-center h-screen">
       <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
           <h1 class="text-2xl font-bold mb-6">Вход</h1>
           <form method="POST" action="{{ route('login') }}">
               @csrf
               <div class="mb-4">
                   <label for="email" class="block text-gray-700">Email</label>
                   <input id="email" type="email" name="email" value="{{ old('email') }}" class="w-full p-2 border rounded" required>
                   @error('email')
                       <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
               </div>
               <div class="mb-4">
                   <label for="password" class="block text-gray-700">Пароль</label>
                   <input id="password" type="password" name="password" class="w-full p-2 border rounded" required>
                   @error('password')
                       <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
               </div>
               <div class="mb-4">
                   <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Войти</button>
               </div>
           </form>
       </div>
   </body>
   </html>
