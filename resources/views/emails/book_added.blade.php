@component('mail::message')
# Hello, {{ name }}

You just added a new book to your list!

@component('mail::panel')
Book Title: {{ bookTitle }}
Author: {{ bookAuthor }}
@endcomponent

@component('mail::button', ['url' => 'https://google.com'])
View List
@endcomponent

Thanks,<br>
Book Management System
@endcomponent
