//Valida se um CPF é válido
function validarCPF(strCPF) {
    strCPF = strCPF.replace(/\D/g, ""); // Remove caracteres não numéricos
  
    if (strCPF.match(/(\d)\1{10}/)) return false; // Verifica se todos os dígitos são iguais
  
    let soma = 0;
    for (let i = 1; i <= 9; i++) {
      soma += parseInt(strCPF.charAt(i - 1)) * (11 - i);
    }
    let resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(strCPF.charAt(9))) return false;
  
    soma = 0;
    for (let i = 1; i <= 10; i++) {
      soma += parseInt(strCPF.charAt(i - 1)) * (12 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(strCPF.charAt(10))) return false;
  
    return true;
}
  

//Validação de CNS
function checkCNS(cns, element) {
    if (!cns || cns.replace(/\s/g, '').length === 0) {
      return true;
    }
  
    cns = cns.replace(/\D/g, '');
  
    if (cns.length !== 15) {
      return false;
    }
  
    const soma = Array.from(cns)
      .slice(0, 14)
      .map((num, index) => parseInt(num) * (15 - index))
      .reduce((acc, curr) => acc + curr, 0);
  
    const digitoVerificador = (soma % 11) === 0 ? 0 : 11 - (soma % 11);
  
    return parseInt(cns.slice(-2)) === digitoVerificador;
}  

//Retorna a idade com base em uma data
function calcAge(dateString) {
    var birthday = +new Date(dateString);
    return ~~((Date.now() - birthday) / (31557600000));
}

//Demonstra o aviso no formulário com a mensagem escolhida
function aviso(msg, addClass) {
    $("#alert").addClass(addClass).html(msg).show().delay(4000).fadeOut("slow");
}
  
//Validar se um email é válido
function validarEmail(email) {
    if (email !== "") {
      return /^[a-z0-9]+@[a-z]+\.[a-z]{2,3}$/.test(email);
    }
    return true;
  }
  