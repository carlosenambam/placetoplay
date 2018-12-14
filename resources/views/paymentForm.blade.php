<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Pago</title>
    <meta charset="utf-8">
</head>
<body>

    @if (count($errors) > 0)
        <p>Errores</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="post" action="/create-transaction">
        {{ csrf_field() }}
        <p>Datos de Comprador:</p>

        <label for="document">Documento*</label>
        <input type="number" name="person[document]" id="document" required><br>

        <label for="document-type">Tipo de Documento</label>
        <select name="person[documentType]" id="document-type" required>
            <option value="CC">Cédula de Ciudadanía</option>
            <option value="CE">Cédula de Extranjería</option>
            <option value="TI">Tarjeta de Identidad</option>
            <option value="PPN">Pasaporte</option>
        </select><br>

        <label for="first-name">Nombres*</label>
        <input type="text" name="person[firstName]" id="first-name" required/><br>

        <label for="last-name">Apellidos*</label>
        <input type="text" name="person[lastName]" id="last-name" required/><br>

        <label for="company">Empresa</label> 
        <input type="text" name="person[company]" id="company" /><br>

        <label for="email-address">Correo Electrónico*</label>
        <input type="email" name="person[emailAddress]" id="email-address" required><br>

        <label for="address">Dirección*</label>
        <input type="text" name="person[address]" id="address" required><br>

        <label for="city">Ciudad*</label>
        <input type="text" name="person[city]" id="city" required><br>

        <label for="province">Departamento*</label>
        <input type="text" name="person[province]" city="province" required><br>

        <label for="country">País*</label>
        <select name="person[country]" id="country" required>
            <option value="" ></option>
            <option value="CO">Colombia</option>
            <option value="USA">USA</option>
        </select><br>

        <label for="phone">Teléfono Fijo*</label>
        <input type="number" name="person[phone]" id="phone" required>

        <label for="mobile">Teléfono Célular*</label>
        <input type="number" name="person[mobile]" id="mobile" required><br><br><br>

        <p>Datos de Transacción</p>
        

        <label for="bank-code">Banco*</label>
        <select name="transaction[bankCode]" id="bank-code" required>
            
            @foreach ($bankList->getBankListResult->item as $bank) 
                <option value="{{ $bank->bankCode }}">{{ $bank->bankName }}</option>
            @endforeach
            
        </select><br>

        <select name="transaction[bankInterface]" required>
            <option value="0">PERSONAS</option>
            <option value="1">EMPRESAS</option>
        </select><br><br>

        <input type="hidden" name="transaction[reference]" value="<?= uniqid() ?>">

        <label for="description">Descripción del pago</label><br>
        <textarea name="transaction[description]" id="description" style="width: 300px; height: 50px;" readonly>
            Pago de Prueba
        </textarea><br><br>

        <input type="hidden" name="transaction[currency]" value="COP">

        <input type="hidden" name="transaction[language]" value="ES">

        <label>Total a pagar: 12.000</label><br><br>
        <input type="hidden" name="transaction[totalAmount]" value="12000.00">

        <input type="submit" value="Pagar">

    </form>
    <br><br>
    <a href="/transaction-list">Lista de Transacciones</a>

</body>
</html>