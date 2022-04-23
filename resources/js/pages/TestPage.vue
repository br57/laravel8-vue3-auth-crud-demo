<template>
    <v-container class="grey lighten-5">
        <v-row justify="center">
            <v-col cols="12" sm="6">
                <h1>
                    Name: {{$route.name}},
                    Params: 
                    <!-- Need to register in route -->
                    <pre>
                        {{$route.params}}
                    </pre>
                    jkl: {{$route.params.jkl}}
                </h1>
                <h2>
                    Query: 
                    <pre>
                        {{$route.query}}
                    </pre>
                </h2>
                <!-- http://laravue3.local/test/asd?brij=232&van=a11 -->
                <v-card color="#f9f9f9" theme="light">
                    <v-card-title class="text-h5">
                        {{ name }}
                        {{ name2 }}
                    </v-card-title>

                    <v-card-subtitle>
                        <div>
                            <TestComponent 
                                @brij="parentSaveData" 
                                :currentName="name" 
                                :key="`cmn_key_${commonKey}`"
                            >
                            <!-- <TestComponent 
                                @brij="parentSaveData" 
                               @eventName="parentSaveData"
                            > -->
                                Slot Text Appear
                            </TestComponent>
                        </div>
                        <div>
                            <TestComponent :names_all="names" />
                        </div>
                    </v-card-subtitle>

                    <v-card-actions>
                        <v-btn variant="text"> Listen Now </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TestComponent from "@/components/TestComponent.vue";
export default {
    name: "TestPage",
    // data(){
    //     return {
    //         name: "Brijesh"
    //     }
    // },
    components: {
        TestComponent,
    },
    data: () => ({
        name: "Vandu",
        name2: null,
        names: ["Brijesh", "Brijesh2", "Ladani"],
        commonKey: Number(new Date())
    }),

    /*CORE*/
    // data: function () {
    //     return {
    //         name: "Brijesh"
    //     }
    // }
    methods: {
        parentSaveData(p1, p2){
            this.name = p1
            this.name2 = p2
            this.commonKey = Number(new Date())
            console.log(p1, p2, 'parentSaveData');
        }
    },


    /*
    components => Object,
    props => data from parent component
    data => Fn => with return object => all key will become variable in the vue instance
    computed => state data
    methods: custom functions

    #Lifecycle Hooks
    1. beforeCreate
    2. created
    3. beforeMount
    4. mounted
        1. beforeUpdate
        2. updated
    5. beforeDestroy
    6. Destroyed

    */
};
</script>
