<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vigenère Cipher</title>
</head>
<body>
    <div>
        <h1>Vigenère Cipher Encryption/Decryption</h1>
        
        <!-- Form for input -->
        <form id="vigenereForm">
            @csrf
            <label for="message">Enter plain text to Encrypt/Decrypt:</label><br>
            <textarea id="message" name="message" rows="4" placeholder="Enter text to encrypt"></textarea><br>
            <label for="key">Key:</label><br>
            <input type="text" id="key" name="key" placeholder="Enter the KEY here"><br>
            <label for="result">Result:</label><br>
            <textarea id="result" rows="4" readonly></textarea><br>
            <button type="button" id="encryptButton">Encrypt</button>
            <button type="button" id="decryptButton">Decrypt</button>
            <button type="button" id="resetButton">Reset</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Encrypt button handling
            document.getElementById('encryptButton').addEventListener('click', function() {
                performAction('encrypt');
            });
    
            // Decrypt button handling
            document.getElementById('decryptButton').addEventListener('click', function() {
                performAction('decrypt');
            });
    
            // Reset button handling
            document.getElementById('resetButton').addEventListener('click', function() {
                document.getElementById('message').value = '';
                document.getElementById('key').value = '';
                document.getElementById('result').value = '';
            });
    
            // Function to perform encryption/decryption
            function performAction(action) {
                const message = document.getElementById('message').value;
                const key = document.getElementById('key').value;
    
                fetch('{{ route('vigenere.process') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        action: action,
                        message: message,
                        key: key
                    })
                })
                .then(response => response.text())
                .then(result => {
                    document.getElementById('result').value = result;
                    Swal.fire({
                        title: 'Success!',
                        text: 'The text has been processed.',
                        icon: 'success',
                        confirmButtonText: 'Great!'
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                });
            }
        });
    </script>

</body>  

<style>
    body {
        font-family: 'Century Gothic', 'League Spartan', sans-serif;
        background-color: #ffffff;
        color: rgb(0, 0, 0);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    #vigenereForm {
        background-color: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    textarea, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #9f9f9f; /* Add a border */
            border-radius: 5px;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
    button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #04c45c;
    }
</style>

</html>