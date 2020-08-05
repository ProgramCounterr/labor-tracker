import { Injectable } from '@angular/core';

import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AccountFormService {

  constructor(private http: HttpClient ) { }

  // function will return some observable from the http request
  sendRequest(data: any): Observable<any> {
    return this.http.post<any>('http://localhost/projects/labor-tracker/formHandlers/accountFormHandler.php', data);
  }
}
