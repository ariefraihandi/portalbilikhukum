/**
 *  Pages Authentication
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          name: {
            validators: {
              notEmpty: {
                message: 'Harap input nama lengkap Anda'
              },
              stringLength: {
                min: 5,
                message: 'Nama minimal menggunakan 5 karakter'
              }
            }
          },
          username: {
            validators: {
              notEmpty: {
                message: 'Harap input username'
              },
              stringLength: {
                min: 5,
                message: 'Username minimal menggunakan 5 karakter'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Harap input email'
              },
              emailAddress: {
                message: 'Email tidak valid'
              }
            }
          },
          'email-username': {
            validators: {
              notEmpty: {
                message: 'Please enter email / username'
              },
              stringLength: {
                min: 5,
                message: 'Username must be more than 5 characters'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Harap input password'
              },
              stringLength: {
                min: 6,
                message: 'Password minimal 6 karakter'
              }
            }
          },
          'confirm-password': {
            validators: {
              notEmpty: {
                message: 'Harap konfirmasi password'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="password"]').value;
                },
                message: 'Password tidak cocok'
              },
              stringLength: {
                min: 6,
                message: 'Password minimal 6 karakter'
              }
            }
          },
          terms: {
            validators: {
              notEmpty: {
                message: 'Please agree terms & conditions'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-3'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),

          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }

    //  Two Steps Verification
    const numeralMask = document.querySelectorAll('.numeral-mask');

    // Verification masking
    if (numeralMask.length) {
      numeralMask.forEach(e => {
        new Cleave(e, {
          numeral: true
        });
      });
    }
  })();
});
