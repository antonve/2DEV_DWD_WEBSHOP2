<div id="error500">
    <h1>Interne server fout.</h1>
    {{if $dev }}
    <p>{{$error}}</p>
    <h1>Stack trace</h1>
    <ul>
        {{foreach $trace as $message}}
        <li>{{$message.file}} op lijn {{$message.line}}</li>
        {{/foreach}}
    </ul>
    {{else}}
    <p>De pagina die u probeert te bereiken kon niet worden geladen.</p>
    {{/if}}
</div>
