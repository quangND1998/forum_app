<template>

    <div>
        <zoom-button></zoom-button>
        <button
            class="text-white bg-red-700 hover:bg-red-800 mb-8 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center mr-2 dark:bg-red-500 dark:hover:bg-red-500 dark:focus:ring-blue-800"
            data-url="" @click="DeleteCheckbox()">
            <icon name="plus" class="w-5 h-5 mr-2 -ml-1"></icon>{{
                    __('delete')
            }} CheckBox
        </button>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">



            <div class="p-4">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for items">
                </div>
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" v-model="selectAll"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sesion
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(zoom, index) in user.zooms" :key="index"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" v-model="selected" :value="zoom.id"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <Link :href="route('admin.session.getZoomCode', zoom.code)">
                            {{ zoom.code }}
                            </Link>

                        </td>

                        <td class="px-6 py-4 text-right">
                            <button class="font-medium text-red-600 dark:text-red-500 hover:underline"
                                @click="deleteZoom(zoom.id)">Delete</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
import ZoomButton from "@/Pages/Zoom/Components/ZoomButton";
import { Link } from "@inertiajs/inertia-vue";
import ZoomForum from "@/Pages/Zoom/Layout";
import Icon from "@/Components/Icon";
export default {
    layout: ZoomForum,
    props: {
        user: Object
    },
    components: {
        ZoomButton,
        Icon,
        Link
    },
    computed: {
        selectAll: {
            get: function () {
                return this.user.zooms ? this.selected.length == this.user.zooms : false;
            },
            set: function (value) {
                var selected = [];

                if (value) {
                    this.user.zooms.forEach(function (zoom) {
                        selected.push(zoom.id);
                    });
                }

                this.selected = selected;
            }
        }
    },
    data() {
        return {
            selected: [],
        }

    },
    methods: {
        DeleteCheckbox() {
            let query = {
                ids: this.selected
            }
            this.$inertia.delete(this.route('admin.session.deleteAll', query))
        },
        deleteZoom(id) {
            if (!confirm("Are you sure want to remove?")) return;
            this.$inertia.delete(this.route("admin.session.delete", id));
        },
    }
}
</script>

<style>
</style>