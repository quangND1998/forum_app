<template>
    <div>
        <BreadCrumb :zoom="zoom"></BreadCrumb>
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
                    <input type="text" id="table-search" v-model="term" @keyup="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for items">
                </div>
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-3">
                            Device name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            DeviceID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            OS version
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Battery
                        </th>
                        <th scope="col" class="px-6 py-3">
                            state
                        </th>
                        <!-- <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(device, index) in devices.data" :key="index"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ device.deviceName }}
                        </th>
                        <td class="px-6 py-4">
                            {{ device.deviceID }}
                        </td>
                        <td class="px-6 py-4">
                            {{ device.os_version }}
                        </td>
                        <td class="px-6 py-4">
                            <icon v-if="device.battery >= 0.7" name="battery-full" class="w-8 h-8"></icon>
                            <icon v-if="device.battery < 0.7 && device.battery > 0.2" name="battery-medium"
                                class="w-8 h-8">
                            </icon>
                            <icon v-if="device.battery < 0.2" name="battery-low" class="w-8 h-8"></icon>
                            {{ Math.round(device.battery * 100)
                            }} %
                        </td>
                        <td class="px-6 py-4">
                            <span v-if="device.pivot.state == 1"
                                class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded">Active</span>
                            <span v-else
                                class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-gray-200 text-gray-700 rounded">Inactive</span>
                        </td>
                        <!-- <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td> -->
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import ZoomForum from "@/Pages/Zoom/Layout";
import Icon from "@/Components/Icon";
import BreadCrumb from "./Components/BreadCrumb";
export default {
    layout: ZoomForum,
    props: {
        devices: Object,
        zoom: Object
    },
    components: {
        Icon,
        BreadCrumb
    },
    data() {
        return {
            term: null,
        }
    },
    mounted() {
        this.listenForDevice();

    },
    methods: {
        search() {
            this.$inertia.get(this.route('admin.session.getZoomCode', this.zoom.code), { term: this.term }, { preserveState: true })
        },
        listenForDevice() {
            var self = this;
            window.socketio.on("device-session." + this.zoom.code + ":App\\Events\\DeviceSessionEvent", function (e) {
                // console.log(e)
                let index = self.devices.data.findIndex(x => x.id == e.id);

                if (index == -1) {
                    self.devices.data.push(e);
                }
                else {
                    self.devices.data.splice(index, 1, e);
                }

            });
        }
    },
}
</script>

<style>
</style>