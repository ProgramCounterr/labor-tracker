import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
	title = 'Rowan\'s site';
  
	fontSize = 16;       /* set default */
	is_dark = false;
	show_settings = false;
	fontFamily = 'Times New Roman';
	fontSizes = [
		{ name: 'small', size: '12' },
		{ name: 'medium', size: '16' },
		{ name: 'large', size: '25' }
	];
	fontFamilies = [
		{ name: 'Times New Roman' },
		{ name: 'Helvetica' },
		{ name: 'Lucida Console' },
		{ name: 'Brush Script MT' }
	];
	toggleDark(){
		this.is_dark = !this.is_dark;
	}
	toggleSettings(){
		this.show_settings = !this.show_settings;
	}
}
