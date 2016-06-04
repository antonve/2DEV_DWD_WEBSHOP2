<div id="register-page">
    <h1>Registreer</h1>
    <form action="{{$root}}/user/register" method="post" id="register_form">
        <fieldset>
            <legend>Registreer</legend>
            <label for="username_reg">Gebruikersnaam</label><br />
            <input type="text" name="register[username]" id="username_reg" class="required {{if isset($error_username)}}error{{/if}}" value="{{$reg_username}}" /><br />
            {{if isset($error_username)}}<div class="error">{{$error_username}}</div>{{/if}}

            <label for="password3">Paswoord</label><br />
            <input type="password" name="register[password]" id="password3" class="required {{if isset($error_password)}}error{{/if}}"  /><br />
            {{if isset($error_password)}}<div class="error">{{$error_password}}</div>{{/if}}

            <label for="password2">Paswoord verificatie</label><br />
            <input type="password" name="register[password2]" class="required {{if isset($error_password2)}}error{{/if}}"  id="password2" /><br />
            {{if isset($error_password2)}}<div class="error">{{$error_password2}}</div>{{/if}}

            <label for="email">Email</label><br />
            <input type="text" name="register[email]" id="email" class="required {{if isset($error_email)}}error{{/if}}" value="{{$reg_email}}" /><br />
            {{if isset($error_email)}}<div class="error">{{$error_email}}</div>{{/if}}

            <label for="firstname">Voornaam</label><br />
            <input type="text" name="register[firstname]" id="firstname" value="{{$reg_lastname}}" /><br />

            <label for="lastname">Naam</label><br />
            <input type="text" name="register[lastname]" id="lastname" value="{{$reg_lastname}}" /><br />
            <br />
            <input type="submit" value="Registreer" />

        </fieldset>
    </form>
</div>
