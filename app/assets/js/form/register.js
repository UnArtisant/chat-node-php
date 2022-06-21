import {Iodine} from "@kingshott/iodine";
import alpine from "alpinejs";


function form_data() {
    const iodine = new Iodine();

    iodine.addRule("matchingPassword", value => {return value === document.getElementById("user_password_first").value})
    iodine.messages.matchingPassword = "Password confirmation needs to match password";

    return {
        email: {error_message: ''},
        password: {error_message: ''},

        email_change: function (e) {
            const el = e.target
            const rules = JSON.parse(el.dataset.rules)
            const err = this.getErrorMessage(el.value, rules)

            if (err) {
                this.email.error_message = err
            } else if (!err && this.email.error_message) {
                this.email.error_message = err
            }
        },
        submit: function (e) {
            const inputs = [...this.$el.querySelectorAll("input[data-rules]")]
            inputs.forEach(input => {
                const rules = JSON.parse(input.dataset.rules)
                const valid = iodine.is(input.value, rules)
                if (valid !== true) {
                    this[input.dataset.field].error_message = iodine.getErrorMessage(valid)
                    e.preventDefault()
                }
            })
        },
        getErrorMessage: function (value, rules) {
            const isValid = iodine.is(value, rules)
            return isValid !== true ? iodine.getErrorMessage(isValid) : null
        }
    }
}

window.form_data = form_data
window.Alpine = alpine
alpine.start()

