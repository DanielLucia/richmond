
    <div class="row">
        <div class="col-4">
            <form action="{'emails_accounts'|url}" method="post">
                <p><input type="email" name="account" placeholder="E-Mail" class="Text" /></p>
                <p><input type="text" name="host" placeholder="Servidor" class="Text" /></p>
                <p><input type="password" name="password" placeholder="Password" class="Text"/></p>
                <p><input type="number" name="port" placeholder="Puerto" class="Text" /></p>
                <p><label><input type="checkbox" name="ssl" value="1"/> SSL</label></p>
                <p><button type="submit" class="Button buttonBlock">Guardar</button></p>
            </form>
        </div>
        <div class="col-8">
<table class="Table">
    <thead>
        <tr>
            <th width="40"></th>
            <th>Cuenta</th>
            <th width="170"></th>
        </tr>
    </thead>
    {foreach from=$emailsAccount key=key item=item}
        <tr>
            <td><input type="checkbox" name="email[]" /></td>
            <td>{$item.account}</td>
            <td class="textRight">
                <a href="javascript:void(0);" class="Button Small">Editar</a>
                <a href="javascript:void(0);" class="Button Small">Borrar</a>
            </td>
        </tr>
    {/foreach}
</table>
</div>
</div>
