<template>
  <section class="container">
    <div class="row">
      <div class="col-12">
        <el-form
            ref="ruleFormRef"
            :model="ruleForm"
            :rules="rules"
            label-width="auto"
            label-position="top"
            status-icon
        >
          <el-form-item label="T.C" prop="tc">
            <el-input v-model="ruleForm.tc" maxlength="11"/>
          </el-form-item>
          <el-form-item label="Adınız" prop="name">
            <el-input v-model="ruleForm.name"/>
          </el-form-item>
          <el-form-item label="Soyadınız" prop="surname">
            <el-input v-model="ruleForm.surname"/>
          </el-form-item>
          <el-form-item label="Email Adresiniz" prop="email">
            <el-input v-model="ruleForm.email"/>
          </el-form-item>
          <el-form-item label="Telefon Numaranız" prop="phone">
            <el-input v-model="ruleForm.phone"/>
          </el-form-item>


          <el-form-item>
            <el-button v-loading.fullscreen.lock="fullscreenLoading" type="primary" @click="submitForm(ruleFormRef)">
              Üye Ol
            </el-button>
            <el-button @click="resetForm(ruleFormRef)">
              Sıfırla
            </el-button>
          </el-form-item>
        </el-form>


      </div>
    </div>
  </section>
</template>

<script lang="ts" setup>
import {onMounted, reactive, ref} from 'vue'
import {ElMessage,ElLoading, FormInstance, FormRules} from 'element-plus'

import axios from "axios";

const fullscreenLoading = ref(false)
interface RuleForm {
  tc: string,
  name: string,
  surname: string,
  email: string,
  phone: string,

}

const ruleFormRef = ref<FormInstance>()

const ruleForm = reactive<RuleForm>({
  tc: '',
  name: '',
  surname: '',
  email: '',
  phone: '',
})
const rules = reactive<FormRules<RuleForm>>({
  name: [
    {required: true, message: 'İsminizi giriniz', trigger: 'blur'},
    {min: 3, message: 'İsminiz en az 3 karakter olmalıdır', trigger: 'blur'},
  ],
  surname: [
    {required: true, message: 'Soyadınızı giriniz', trigger: 'blur'},
    {min: 3, message: 'Soyadınız en az 3 karakter olmalıdır', trigger: 'blur'},
  ],
  tc: [
    {required: true, message: 'TC Kimlik numaranızı giriniz', trigger: 'blur'},
    {min: 11, max: 11, message: 'TC Kimlik numaranız 11 karakter olmalıdır', trigger: 'blur'},
  ],
  email: [
    {required: true, message: 'Email adresinizi giriniz', trigger: 'blur'},
    {type: 'email', message: 'Geçerli bir email adresi giriniz', trigger: 'blur'},
  ],
  phone: [
    {required: true, message: 'Telefon numaranızı giriniz', trigger: 'blur'},
    {
      pattern: /^[1-9][0-9]{9}$/,
      message: 'Telefon numaranız 10 haneli olmalı ve 0 ile başlamamalıdır',
      trigger: 'blur'
    },
  ],
})

const submitForm = async (formEl: FormInstance | undefined) => {
  fullscreenLoading.value = true
  if (!formEl) return
  await formEl.validate((valid, fields) => {
    if (valid) {
      axios.post('/api/insert.php', {...ruleForm, token: localStorage.getItem('auth-key')}, {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      }).then(res => {
        console.log(res.data)
        fullscreenLoading.value = false;
        ElMessage({
          message: 'Üyelik işlemi başarılı',
          type: 'success',
        })
      })
    } else {
      console.log('error submit!', fields)
    }
  })
}

const resetForm = (formEl: FormInstance | undefined) => {
  if (!formEl) return
  formEl.resetFields()
}
</script>
