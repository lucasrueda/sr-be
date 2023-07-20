<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Balanced Teams</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="antialiased flex justify-center align-center">

<div class="overflow-auto max-w-7xl h-4/6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Team
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Ranking
            </th>
            <th scope="col" colspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Players
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200  h-4/6">
        @foreach($teams as $team)

            <tr class="hover:font-bold">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{$team['name']}}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{$team['ranking']}}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{sizeof($team['players'])}}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">
                        <div class="flex justify-start align-center flex-wrap">
                            @foreach($team['players'] as $user)
                                <span
                                    title="{{$user['is_goalie'] ? 'Goalie' : 'Player'}}"
                                    class="flex-grow-1 flex-shrink-1 flex-basis-0
                                font-medium
                                text-sm
                                hover:font-bold
                                hover:cursor-pointer
                                bg-{{$user['is_goalie'] ? 'red':'blue'}}-100
                                text-{{$user['is_goalie'] ? 'red':'blue'}}-800
                                mr-2 px-2.5 py-0.5 rounded dark:bg-{{$user['is_goalie'] ? 'red':'blue'}}-900
                                dark:text-{{$user['is_goalie'] ? 'red':'blue'}}-300">
                                    {{$user->fullName}} - {{$user->ranking}}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


</body>
</html>
