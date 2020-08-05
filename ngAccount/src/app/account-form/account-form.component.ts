import { Component, OnInit } from '@angular/core';
import { AccountFormService } from '../account-form.service';

@Component({
  selector: 'app-account-form',
  templateUrl: './account-form.component.html',
  styleUrls: ['./account-form.component.css']
})
export class AccountFormComponent implements OnInit {

  constructor(private accountService: AccountFormService ) { }

  ngOnInit(): void {
  }

  responsedata = "";
  url = new URL(location.href);
  urlParams = this.url.searchParams;
  user = this.urlParams.get('user');

  onSubmit(form: any): void {
    form['username'] = this.user; // add username to form data
    // transform data into json
    let params = JSON.stringify(form);
    console.log(params);
    this.accountService.sendRequest(params)
    .subscribe((data) => {
      this.responsedata = data;
      if(data['code'] === 200)
        location.replace('http://localhost/projects/labor-tracker/logout.php'); // redirect to login page
    }, (error) => {
      console.log('Error ', error);
    });
  }
}
