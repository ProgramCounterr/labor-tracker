import { Component, OnInit } from '@angular/core';
import { UrlResolver } from '@angular/compiler';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  constructor() { }
  ngOnInit(): void {
  }
  url = new URL(location.href);
  params = this.url.searchParams;
  user = this.params.get('user');
}
