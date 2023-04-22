const validation = new JustValidate("#signup");

validation
    .addField("#name", [
        {
            rule: "required"
        }
    ])
    .addField("#email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                       .then(function(response) {
                           return response.json();
                       })
                       .then(function(json) {
                           return json.available;
                       });
            },
            errorMessage: "email already taken"
        }
    ])
    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#password_confirmation", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });
    
    /*Vytvorí sa nová inštancia JustValidate, ktorá sa bude používať na validáciu formulára s id "signup".
Pridá sa validácia pre pole s id "name", kde sa požaduje povinnosť vyplnenia.
Pridá sa validácia pre pole s id "email", kde sa požaduje povinnosť vyplnenia a formát emailu. Taktiež sa pridá vlastný validátor, 
ktorý pomocou fetch() odosle požiadavku na server na overenie, či je email už registrovaný. Ak áno, vráti sa správa o chybe.
Pridá sa validácia pre pole s id "password", kde sa požaduje povinnosť vyplnenia a zadaný text musí splňovať kritéria pre silné heslo.
Pridá sa validácia pre pole s id "password_confirmation", kde sa overí zhoda s hodnotou zadanou v poli s id "password".
Ak sú všetky validácie prebehnuté úspešne, spustí sa funkcia onSuccess, ktorá odošle formulár na server. */