import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
// import { ToastrService } from 'ngx-toastr';
import { DataService } from '../service/data.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent implements OnInit {
  submitted: boolean = false;
  form!: FormGroup;
  data: any;
  token: any;
  constructor(
    private formBuilder: FormBuilder,
    private dataservice: DataService,
    private toastr: ToastrService,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.loginForm();
  }
  get f() {
    return this.form.controls;
  }
  loginForm() {
    this.form = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(6)]],
    });
  }
  submit() {
    this.submitted = true;
    if (this.form.invalid) {
      console.log(this.form);
      return;
    }
    this.dataservice.login(this.form.value).subscribe((res) => {
      this.data = res;

      if (this.data.success == true) {
        this.token = this.data.access_token;
        localStorage.setItem('token', this.token);

        this.router.navigate(['']);
        this.toastr.success(
          JSON.stringify(this.data.message),
          JSON.stringify(this.data.code),
          {
            timeOut: 2000,
            progressBar: true,
          }
        );
      } else {
        this.toastr.error(
          JSON.stringify(this.data.message),
          JSON.stringify(this.data.code),
          {
            timeOut: 2000,
            progressBar: true,
          }
        );
      }
      this.submitted = false;
      this.form.get('name')?.reset();
      this.form.get('email')?.reset();
      this.form.get('password')?.reset();
      this.form.get('confirmPassword')?.reset();
    });
  }
}
