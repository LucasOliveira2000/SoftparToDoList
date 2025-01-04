<template>
    <!-- Toasts são gerados automaticamente através do Notify do Quasar -->
  </template>

  <script>
  import { Notify } from 'quasar';

  export default {
    mounted() {
      this.checkSessionMessages();
    },
    methods: {
      checkSessionMessages() {
        // Verifica se existem mensagens de sucesso ou erro na sessão
        const sessionMessages = this.$page.props.flash;

        if (sessionMessages) {
          // Exibe as mensagens de sucesso
          if (sessionMessages.sucesso) {
            this.showToast(sessionMessages.sucesso, 'positive');
          }
          // Exibe as mensagens de erro
          if (sessionMessages.erro) {
            this.showToast(sessionMessages.erro, 'negative');
          }
        }
      },
      showToast(message, type) {
        // Cria o toast usando o Quasar Notify
        Notify.create({
          message: message,
          color: type, // Pode ser 'positive', 'negative', etc.
          position: 'top', // Onde o toast aparece (top, bottom, etc.)
          timeout: 3000, // Tempo de exibição do toast (em ms)
          icon: type === 'positive' ? 'check_circle' : 'error', // Ícone baseado no tipo
        });
      },
    },
  };
  </script>
