import { Injectable } from '@angular/core';

import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthorizationService {

  constructor(private http: HttpClient) { }

  // function will return some observable from the http request
  checkForUser(data: any): Observable<any> {
    return this.http.post<any>('http://localhost/projects/labor-tracker/authorize.php', data);
  }

}
