
<div class="container" style="padding: 1rem; background: #f5f5f5;">
    <p>{{__('mail.successful_reset')}}</p>
    <p>
        {{__('mail.dear')}} {{session('user_name')}}, {{__('mail.successful_description')}}
    </p>
    <br>
    <p>
        {{__('mail.new_password')}} : {{session('user_new_pwd')}}
    </p>
</div>
