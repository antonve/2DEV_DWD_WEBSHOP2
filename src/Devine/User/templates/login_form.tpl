<h1>Login</h1>
<div id="loginform">
    <form action="{{$root}}/user/login" method="post" id="login_page" >
    <fieldset>
        {{if isset($error_login) }}<div class="error">{{$error_login}}</div>{{/if}}

        <input type="text" value="Gebruikersnaam" name="username" />
        <input value="Paswoord" type="password" name="password" />
        <div class="remember_me"><input type="checkbox" id="remember_me_page" name="remember_me" /> <label for="remember_me">Onthouden?</label></div>
        <input type="submit" value="Log in"/>
        <div class="clearfix"></div>
        <a href="{{$root}}/user/register">Registreer &raquo;</a>
    </fieldset>
    </form>
</div>
