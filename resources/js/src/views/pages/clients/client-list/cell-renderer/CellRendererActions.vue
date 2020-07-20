<template>
    <div :style="{'direction': $vs.rtl ? 'rtl' : 'ltr'}">
      <feather-icon icon="SearchIcon" svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer" @click="editRecord" />
    </div>
</template>

<script>
    import Cookies from "js-cookie";

    export default {
        name: 'CellRendererActions',
        methods: {
          editRecord() {
            this.$router.push("/clients/edit/" + this.params.data.id).catch(() => {})

            /*
              this.$router.push("/apps/user/user-edit/" + this.params.data.id).catch(() => {})
            */
          },
          confirmDeleteRecord() {
            this.$vs.dialog({
              type: 'confirm',
              color: 'danger',
              title: `Confirm Delete`,
              text: `You are about to delete "${this.params.data.username}"`,
              accept: this.deleteRecord,
              acceptText: "Delete"
            })
          },
          deleteRecord() {
            /* UnComment below lines for enabling true flow if deleting user */
            this.$store.dispatch("userManagement/removeRecord", this.params.data.id)
              .then(()   => { this.showDeleteSuccess() })
              .catch(err => { console.error(err)       })
          },
          showDeleteSuccess() {
            this.$vs.notify({
              color: 'success',
              title: 'User Deleted',
              text: 'The selected user was successfully deleted'
            })
          }
        }
    }
</script>
