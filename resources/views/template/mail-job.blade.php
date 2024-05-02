
<div class="container" style="padding: 1rem; background: #f5f5f5;">
    <p>{{__('mail.you_got_job_assigned')}}</p>
    <p>
        {{__('mail.date')}} : {{session('start_date')}} - {{session('end_date')}}
    </p>
    <p>
        {{__('mail.title')}} : {{session('job_title')}}
    </p>
    <p>
        {{__('mail.context')}} : {{session('job_context')}}
    </p>
    <p>
        {{__('mail.assigned_from')}} : {{session('assigned_from')}}
    </p>
    <p>
        {{__('mail.assigned_from_mail')}} : {{session('assigned_from_mail')}}
    </p>
</div>
