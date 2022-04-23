<template>
    <div>
        1<slot></slot>
        <div
            v-for="(nm, nk) in names_all"
            :key="`brij_${nk}_${nk == 0 ? nk : nk + 1}`"
        >
            {{ nm }}
        </div>
        <div>
            <h4>Intenrnadata</h4>
            <div
                v-for="(nm, ink) in names"
                :key="`brij_${ink}_${ink == 0 ? ink : ink + 1}`"
            >
                {{ nm }}
            </div>
        </div>
        <h3>
            counter: {{counter}}
        </h3>
        <v-btn flat @click="saveData">Counter+</v-btn>
        <template v-if="currentName !== null">
            <v-btn flat @click="changeTitle">Change Title</v-btn>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        names_all: {
            type: [Array, Object],
            default: ["rajkot", "jamanaga", "jkash"],
            required: false,
        },
        currentName: {
            type: [String],
            default: null,
            required: false,
        },
    },
    data: () => ({
        names: ["innerData", "innerData2"],
        counter: 0
    }),
    methods: {
        /*
        CORE*/
        saveData() {
            this.counter++
        },
        changeTitle(){
            let sendName = this.currentName == "Vandu" ? "Divyesh" : "Vandu"
            this.$emit('brij', sendName, 'Brijesh') // this.$emit('eventName', p1, p2)
        }
    }
};
</script>
