<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styleforget.css">
    <title>Document</title>
</head>


<body></body>

    <form class="honda">
        <fieldset style="background-color: rgb(255, 255, 255);">
            <legend> forget password </legend>
            <div>
                <label>your phone number</label>
                <input type="text" id="number" placeholder=" number phone">
                <span id="error"></span>
            </div>

       

            <br><br>
            <label>your gmail</label>
            <input type="email" placeholder="@gmail">
            <br><br>
            <label>code</label>
            <input type="password"placeholder="code">
         
            <br><br>
            <button type="submit"
            onclick="errorMessage()">
             Submit
            </button>


    </form>

</body>

</html>

