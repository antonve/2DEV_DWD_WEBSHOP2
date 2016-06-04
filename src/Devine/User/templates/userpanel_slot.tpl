{{if isset($user) }}
Welkom, {{$user->getUsername()|escape}}. <span class="userpanel_links"><a href="{{$root}}/user/logout">Log uit &raquo;</a><a href="{{$root}}/user/profile">Profiel &raquo;</a></span>
{{else}}
<form action="{{$root}}/user/login" method="post" id="login" >
    <fieldset>
        <input type="text" value="Gebruikersnaam" name="username" />
        <input value="Paswoord" type="password" name="password" />
        <div class="remember_me"><input type="checkbox" id="remember_me" name="remember_me" /> <label for="remember_me">Onthouden?</label></div>
        <input type="submit" value="Log in"/>
        <div class="clearfix"></div>
        <a href="{{$root}}/user/register" id="register">Registreer &raquo;</a>
    </fieldset>
</form>
{{/if}}
