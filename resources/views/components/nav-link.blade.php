@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';

$commonStyle = 'width: 14.6875rem;
                height: 3.1875rem;
                flex-shrink: 0;
                font-size: 1rem;
                font-style: normal;
                font-weight: 600;
                line-height: normal;
                letter-spacing: 0.01875rem;
                border-radius: 1.25rem;';
$styles = ($active ?? false)
            ?  $commonStyle.'color:#fff !important; background: var(--3, #303030);'
            :  $commonStyle.'color:#000 !important; background-color:#fff !important;';
$fill = ($active ?? false)? '#fff':'#000';
@endphp
<a {{ $attributes->merge(['class' => $classes, 'style'=> $styles]) }} >
    @if ($active)
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="{{ $fill }}"  class="m-2">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.33362 11.4982C7.33362 11.2227 7.55427 10.9995 7.83483 10.9995H12.8321C13.1089 10.9995 13.3333 11.2226 13.3333 11.4982V15.0005C13.3333 15.2759 13.1127 15.4992 12.8321 15.4992H7.83483C7.55802 15.4992 7.33362 15.2761 7.33362 15.0005V11.4982ZM7.33362 0.99736C7.33362 0.722676 7.55427 0.5 7.83483 0.5H12.8321C13.1089 0.5 13.3333 0.725451 13.3333 0.99736V9.50215C13.3333 9.77683 13.1127 9.99951 12.8321 9.99951H7.83483C7.55802 9.99951 7.33362 9.77405 7.33362 9.50215V0.99736ZM0.333984 6.49707C0.333984 6.22239 0.554632 5.99971 0.835195 5.99971H5.83246C6.10927 5.99971 6.33367 6.22516 6.33367 6.49707V15.0019C6.33367 15.2765 6.11302 15.4992 5.83246 15.4992H0.835195C0.558385 15.4992 0.333984 15.2738 0.333984 15.0019V6.49707ZM0.333984 0.998746C0.333984 0.723296 0.554632 0.5 0.835195 0.5H5.83246C6.10927 0.5 6.33367 0.723144 6.33367 0.998746V4.50102C6.33367 4.77647 6.11302 4.99977 5.83246 4.99977H0.835195C0.558385 4.99977 0.333984 4.77662 0.333984 4.50102V0.998746Z" fill="white"/>
        </svg>
    @else
        <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-2">
            <g id="Group">
            <g id="Group_2">
            <path id="Vector" fill-rule="evenodd" clip-rule="evenodd" d="M7.33362 11.4982C7.33362 11.2227 7.55427 10.9995 7.83483 10.9995H12.8321C13.1089 10.9995 13.3333 11.2226 13.3333 11.4982V15.0005C13.3333 15.2759 13.1127 15.4992 12.8321 15.4992H7.83483C7.55802 15.4992 7.33362 15.2761 7.33362 15.0005V11.4982ZM7.33362 0.99736C7.33362 0.722676 7.55427 0.5 7.83483 0.5H12.8321C13.1089 0.5 13.3333 0.725451 13.3333 0.99736V9.50215C13.3333 9.77683 13.1127 9.99951 12.8321 9.99951H7.83483C7.55802 9.99951 7.33362 9.77405 7.33362 9.50215V0.99736ZM0.333984 6.49707C0.333984 6.22239 0.554632 5.99971 0.835195 5.99971H5.83246C6.10927 5.99971 6.33367 6.22516 6.33367 6.49707V15.0019C6.33367 15.2765 6.11302 15.4992 5.83246 15.4992H0.835195C0.558385 15.4992 0.333984 15.2738 0.333984 15.0019V6.49707ZM0.333984 0.998746C0.333984 0.723296 0.554632 0.5 0.835195 0.5H5.83246C6.10927 0.5 6.33367 0.723144 6.33367 0.998746V4.50102C6.33367 4.77647 6.11302 4.99977 5.83246 4.99977H0.835195C0.558385 4.99977 0.333984 4.77662 0.333984 4.50102V0.998746Z" fill="#303030"/>
            </g>
            </g>
        </svg>
    @endif
    {{ $slot }}
</a>
