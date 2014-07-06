#include <stdio.h>
#include <string.h>

#define BUF_SIZE 1024

int main(int argc, char *argv[])
{
  FILE *fp;
  char linebuf[BUF_SIZE];
  int buflen;
  int slot;
  int i, k;

  if (argc < 2)
  { printf("parameter 1: FloorAccess.txt\n"); return 0; }
  fp = fopen(argv[1], "r");
  /* skip first line */
  fgets(linebuf, BUF_SIZE, fp);
  while (fgets(linebuf, BUF_SIZE, fp) != NULL)
  {
/*    printf("\nlinebuf: %s", linebuf); getchar(); */
    if (strchr(linebuf, 'Y') == NULL) continue;

    sscanf(linebuf, "%d", &slot);
/*    printf("Slot[%d]: ", slot); */
    if (slot == 0) continue;
    k = 1;
    buflen = strlen(linebuf);
    for (i = 5;i < buflen;i ++)
    {
      if (linebuf[i] == ' ') continue;
      if (linebuf[i] == 'Y')
      {
/*        printf(" %d", k); */
        printf("INSERT INTO floor_access (address,floor) VALUES ('%d','%d');\n",
	  slot, k);
      }
      k ++;
    }
/*    printf("\n"); */
  }

  fclose(fp);
  return 0;
}

