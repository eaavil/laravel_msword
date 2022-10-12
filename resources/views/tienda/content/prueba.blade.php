
<!DOCTYPE html>
<html>
 <head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Input File Text Demo</title>


        <style>
            .button-class {
                border: none;
                padding: 10px 15px 10px 15px;
                font-size: medium;
            }

            .text-class {
                color: #777777;
            }
        </style>
    </head>

    <body>
        <h1>Input File Text Demo</h1>

        <h2>Why do I need this plugin?</h2>
        <p>
            The appearance of an input file element is browser dependant.
        </p>
        <dl>
            <dt>In Chrome</dt>
            <dd><img src="images/chrome.png"/></dd>
            <dt>In FireFox</dt>
            <dd><img src="images/firefox.png"/></dd>
            <dt>In Internet Explorer</dt>
            <dd><img src="images/internetExplorer.png"/></dd>
        </dl>
        <p>
            This plugin's purpose is to 'over-ride' the default appearance with our own.
        </p>

        <h2>How to use</h2>
        <ol>
            <li>
                <a href="../src/jquery-input-file-text.js" target="_blank">
                    Download this plugin.
                </a>
            </li>
            <li>
                Add this script after JQuery.
                <pre><code>
                    &lt;script src='jquery-input-file-text.js'&gt;&lt;/script&gt;
                </code></pre>
            </li>
            <li>
                Create an input file element.
                <pre><code>
                    &lt;input type="file" id="choose-file" /&gt;
                </code></pre>
            </li>
            <li>
              
                <h3>Result</h3>
                
        <script src='https://code.jquery.com/jquery-1.6.4.min.js'></script>
        <script src='../src/jquery-input-file-text.js'></script>
                <input type="file" id="choose-file" />
            </li>
        </ol>

        <script>
            $(document).ready(function() {
                $('#choose-file').inputFileText({
                    text: 'subir recibo',
                    buttonClass: 'button-class',
                    textClass: 'text-class'
                });
            });
        </script>
    </body>
</html>