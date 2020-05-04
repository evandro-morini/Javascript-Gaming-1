pipeline {
  agent any
    
  tools {nodejs "node"}
    
  stages {
               
    stage('Install dependencies') {
      steps {
        //sh 'npm install'
      }
    }
     
    stage('Test') {
      steps {
         //sh 'npm test'
      }
    }

    stage('Deploy to Heroku') {
      steps {
        script {
          withCredentials([[$class: 'UsernamePasswordMultiBinding',
              credentialsId: 'heroku',
                usernameVariable: 'USERNAME', passwordVariable: 'PASSWORD']]) {
                  sh "echo 'machine git.heroku.com login $USERNAME password $PASSWORD' > ~/.netrc"
                  sh "chmod 600 ~/.netrc"
                  sh "git push -f https://git.heroku.com/javascript-gaming-1.git HEAD:master"
                }
          }
        }             
    }  
  }
}