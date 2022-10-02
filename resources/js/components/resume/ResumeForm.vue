<template>


    <div class="mt-10 mb-10">
      <Alert 
        v-if="alert.messages.length > 0"
        :messages="alert.messages"
        :type="alert.type"
        />
        <div class="row mb-3">
            <div class="col-sm-8">
                <div class="formt-group">
                    <input 
                        v-model="resume.title"
                        placeholder="Resume Title"
                        required
                        autofocus
                        class="fotm-control w-100"
                    />
                </div>
            </div>
            <div class="col-sm-4">
                <button class="btn btn-success btn-block" @click="submit()">
                    submit <i class="fa fa-upload"></i>
                </button>
            </div>
        </div>
        <Tabs>
            <Tab title="Basics" icon="fas fa-user">
                <ViewFormGenerator
                    :schema="schemas.basics"
                    :model="resume.content.basics"
                    :options="options"
                />
                <ViewFormGenerator
                    :schema="schemas.location"
                    :model="resume.content.basics.location"
                    :options="options"
                />
            </Tab>
            <Tab title="Profiles" icon="fa fa-users">
                <DynamicForm 
                    title="Profile"
                    :model="resume.content.basics"
                    :schema="schemas.profiles"
                    self="profiles" />
            </Tab>
             <Tab title="Work" icon="fa-solid fa-briefcase">
                <DynamicForm 
                    title="Work"
                    :model="resume.content"
                    :schema="schemas.work"
                    :subforms="subforms.work"
                    self="work" />
            </Tab>
            <Tab title="Education" icon="fa-solid fa-graduation-cap">
                <DynamicForm 
                    title="Education"
                    :model="resume.content"
                    :schema="schemas.education"
                    :subforms="subforms.education"
                    self="education" />
            </Tab>
            <Tab title="Skills" icon="fa-solid fa-lightbulb">
                <DynamicForm 
                    title="Skill"
                    :model="resume.content"
                    :schema="schemas.skills"
                    :subforms="subforms.skills"
                    self="skills" />
            </Tab>
            <Tab title="Awards" icon="fa-solid fa-trophy">
                <DynamicForm 
                    title="Skill"
                    :model="resume.content"
                    :schema="schemas.awards"
                    :subforms="subforms.awards"
                    self="awards" />
            </Tab>
        </Tabs>
    </div>
</template>

<script>
import jsonresume from "./jsonresume";
import basics from './schema/basics/basics';
import location from './schema/basics/location';
import profiles from './schema/basics/profiles';
import work from './schema/work';
import education from './schema/education';
import awards from './schema/awards';
import skills from './schema/skill';
import FieldResumeImage from './vfg/FieldResumeImage.vue';
import Tabs from './tabs/Tabs';
import Tab from './tabs/Tab';
import { component as ViewFormGenerator } from 'vue-form-generator';
import 'vue-form-generator/dist/vfg.css';
import DynamicForm from './dynamic/DynamicForm'
import ListForm from './dynamic/ListForm.vue';
import Alert from '../reusable/alert.vue';

export default {
    name: "ResumeForm",
    components: {
        Tabs,
        Tab,
        ViewFormGenerator,
        FieldResumeImage,
        DynamicForm,
        Alert
    },
    props: {
        update: false,
        resume: {
            type: Object,
            default: () => ({
                id: null,
                title: 'Resume Title',
                content: jsonresume
            })
        }
    },
    data() {
        return {
            alert:{
                type: 'warning',
                messages: []
            },
            schemas: {
                basics,
                location,
                profiles,
                work,
                education,
                awards,
                skills
            },

            subforms: {
                work: [
                    {
                        component: ListForm,
                        props: {
                            title: 'Highlights',
                            self: 'highlights',
                            placeholder: 'Started the company'
                        }
                    }
                ],
                education: [
                    {
                        component: ListForm,
                        props: {
                            title: 'Courses',
                            self: 'courses',
                            placeholder: 'DB1101 - SQL'
                        }
                    }
                ],
                skills: [
                    {
                        component: ListForm,
                        props: {
                            title: 'Keywords',
                            self: 'keywords',
                            placeholder: 'Javascript, html, css...s'
                        }
                    }
                ]
                
            },
            options: {
                validateAfterLoad: true,
                validateAfterChanged: true,
                validateAsync: true,
            },
        };
    },
    methods: {
        async submit(){
            try{
                const res = this.update
                    ? await axios.put(route('resumes.update', this.resume.id), this.resume)
                    : await axios.post(route('resumes.store'), this.resume);
                console.log(res.data);
                window.location = '/resumes';
            } catch(e){
                const errors = e.response.data.errors;
                for (const [prop, value] of Object.entries(errors)) {
                    let origin = prop.split('.');
                    if(origin[0] === 'content'){
                        origin.splice(0, 1);
                    }
                    origin = origin.join(' > ');
                    for (const error of value) {
                        const message = error.replace(prop, `<strong>${origin}</strong>`);
                        this.alert.messages.push(message)
                    }
                }

                this.alert.type = 'danger';
            }
        }
    }
};
</script>
