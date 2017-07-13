<template>
    <div class="section page-login">
        <div class="container">
            <div class="row">
                <div class="col s12 m8 offset-m2">
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <h4>{{ title }} - {{ user.name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import store from "../store";

    export default {
        data() {
            return {
                title: 'Dashboard'
            }
        },
        computed: {
            user() {
                return store.state.user;
            }
        }
    }
</script>
