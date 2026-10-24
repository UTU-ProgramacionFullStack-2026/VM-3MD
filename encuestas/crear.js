// Cuenta cuántas preguntas se agregaron, para darle a cada una un número distinto
let cantidad = 0;

function agregarPregunta() {
  cantidad++;

  // Los nombres preguntas[1][texto], preguntas[1][tipo]...
  // llegan a PHP como un array de preguntas
  let html = `
        <fieldset>
            <legend>Pregunta ${cantidad}</legend>

            <label>Texto de la pregunta</label><br>
            <input type="text" name="preguntas[${cantidad}][texto]" required><br>

            <label>Tipo de respuesta</label><br>
            <select name="preguntas[${cantidad}][tipo]">
                <option value="binaria">Binaria (sí / no)</option>
                <option value="escala">Escala (1 al 10)</option>
                <option value="texto">Texto</option>
            </select>
        </fieldset>
    `;

  // insertAdjacentHTML agrega al final sin borrar lo que ya se escribió
  document.getElementById("preguntas").insertAdjacentHTML("beforeend", html);
}

// Arrancamos con una pregunta ya agregada
agregarPregunta();
