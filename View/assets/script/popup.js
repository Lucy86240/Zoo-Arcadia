function popup(dialog, trigger, dismissTrigger){
    document.addEventListener('DOMContentLoaded', () => {  
    
      const open = function (dialog) {
        dialog.setAttribute('aria-hidden', false);
      };
    
      const close = function (dialog) {
        dialog.setAttribute('aria-hidden', true);
      };
    
        // open dialog
      trigger.addEventListener('click', (event) => {
        event.preventDefault();
        open(dialog);
        dismissTrigger.addEventListener('click', (event) => {
          event.preventDefault();
          close(dialog);
        });
    
        window.addEventListener('click', (event) => {
          if (event.target === dialog) {
            close(dialog);
          }
        });
      });
    });
  }