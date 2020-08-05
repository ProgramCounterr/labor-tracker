import { Component, OnInit } from '@angular/core';
import { AuthorizationService } from './authorization.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {

  title = 'ngAccount';
  url = new URL(location.href); // get current url
  params = this.url.searchParams;
  user = this.params.get('user');

  constructor(private authorizeServce: AuthorizationService) { }

  authenticate () {
    if(!this.user)
      location.replace('http://localhost/projects/labor-tracker/login.php'); // redirect to login page
    else {
      // send request
      this.authorizeServce.checkForUser(JSON.stringify({'username': this.user }))
      .subscribe((data) => {
        if(data['code'] !== 200)
          location.replace('http://localhost/projects/labor-tracker/login.php'); // redirect to login page
      });
    }
  }

  ngOnInit() {
    this.authenticate();
  }

}
