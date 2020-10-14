@component('mail::message')
# Hello, {{ name }}

You just deleted a book from you list.

@component('mail::panel')
Book Title: {{ bookTitle }}
Author: {{ bookAuthor }}
@endcomponent

@component('mail::button', ['url' => 'https://google.com'])
View Updated List
@endcomponent

Kindly report to the management if this action is not initiated by you.

Thanks,<br>
Book Management System
@endcomponent
